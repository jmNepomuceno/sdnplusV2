$(document).ready(function () {
    const toggleBtn = document.getElementById("darkModeToggle");
    console.log(toggleBtn)

    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
            // Change button text
            if (document.body.classList.contains("dark-mode")) {
                toggleBtn.textContent = "☀️ Light Mode";
            } else {
                toggleBtn.textContent = "🌙 Dark Mode";
            }
        });
    }

    function updateAverages(data) {
        if (!Array.isArray(data) || data.length === 0) {
            $("#totalReferrals").text(0);
            $("#avgReception").text("--");
            $("#avgApproval").text("--");
            $("#fastestResponse").text("--");
            $("#slowestResponse").text("--");
            return;
        }

        let allReferrals = [];
        data.forEach(hospital => {
            if (Array.isArray(hospital.referrals)) {
                allReferrals = allReferrals.concat(hospital.referrals);
            }
        });

        if (allReferrals.length === 0) {
            $("#totalReferrals").text(0);
            return;
        }

        let receptionDiffs = [];
        let approvalDiffs = [];
        let responseTimes = [];

        allReferrals.forEach(item => {
            let start = new Date(item.date_time);
            let reception = item.reception_time ? new Date(item.reception_time) : null;
            let approved = item.approved_time ? new Date(item.approved_time) : null;

            if (reception) {
                let receptionDiff = (reception - start) / 1000;
                if (receptionDiff >= 0) receptionDiffs.push(receptionDiff);
            }

            if (reception && approved) {
                let approvalDiff = (approved - reception) / 1000;
                if (approvalDiff >= 0) approvalDiffs.push(approvalDiff);
            }

            if (item.final_progressed_timer) {
                let parts = item.final_progressed_timer.split(":").map(Number);
                let seconds = parts[0] * 3600 + parts[1] * 60 + parts[2];
                responseTimes.push(seconds);
            }
        });

        const avg = arr => arr.length ? (arr.reduce((a, b) => a + b, 0) / arr.length) : 0;
        const formatSecs = secs => {
            if (!secs || secs <= 0 || !isFinite(secs)) return "--";
            let h = Math.floor(secs / 3600);
            let m = Math.floor((secs % 3600) / 60);
            let s = Math.floor(secs % 60);
            return [h, m, s].map(v => String(v).padStart(2, "0")).join(":");
        };

        $("#totalReferrals").text(allReferrals.length);
        $("#avgReception").text(formatSecs(avg(receptionDiffs)));
        $("#avgApproval").text(formatSecs(avg(approvalDiffs)));
        $("#fastestResponse").text(formatSecs(Math.min(...responseTimes)));
        $("#slowestResponse").text(formatSecs(Math.max(...responseTimes)));
    }

    function updateCharts(data) {
        let caseCategoryCounts = {};
        let caseTypeCounts = {};
        let facilityCounts = {};

        // Flatten referrals across all hospitals
        let allReferrals = [];
        data.forEach(h => {
            if (Array.isArray(h.referrals)) {
                allReferrals = allReferrals.concat(h.referrals);
            }
        });

        // If no data, clear all charts
        if (allReferrals.length === 0) {
            console.warn("No referral data available for charts.");

            if (document.getElementById("chart-case-category")) {
                Highcharts.chart("chart-case-category", {
                    title: { text: "Case Category" },
                    subtitle: { text: "No data available" },
                    series: [{ data: [] }]
                });
            }
            if (document.getElementById("chart-case-type")) {
                Highcharts.chart("chart-case-type", {
                    title: { text: "Case Type" },
                    subtitle: { text: "No data available" },
                    series: [{ data: [] }]
                });
            }
            if (document.getElementById("chart-referring-facility")) {
                Highcharts.chart("chart-referring-facility", {
                    title: { text: "Referring Health Facility" },
                    subtitle: { text: "No data available" },
                    series: [{ data: [] }]
                });
            }

            return;
        }

        // Count values
        allReferrals.forEach(r => {
            // Case Category
            let category = r.pat_class || "Deferred";
            caseCategoryCounts[category] = (caseCategoryCounts[category] || 0) + 1;

            // Case Type
            let type = r.type || "Unknown";
            caseTypeCounts[type] = (caseTypeCounts[type] || 0) + 1;

            // Referring Facility
            let facility = r.referred_by || "Unknown";
            facilityCounts[facility] = (facilityCounts[facility] || 0) + 1;
        });

        // --- Render Case Category Pie ---
        if (document.getElementById("chart-case-category")) {
            Highcharts.chart("chart-case-category", {
                chart: { type: "pie", options3d: { enabled: true, alpha: 45 } },
                title: { text: "Case Category" },
                series: [{
                    name: "Referrals",
                    data: Object.entries(caseCategoryCounts).map(([k, v]) => ({ name: k, y: v }))
                }]
            });
        }

        // --- Render Case Type Pie ---
        if (document.getElementById("chart-case-type")) {
            Highcharts.chart("chart-case-type", {
                chart: { type: "pie", options3d: { enabled: true, alpha: 45 } },
                title: { text: "Case Type" },
                series: [{
                    name: "Referrals",
                    data: Object.entries(caseTypeCounts).map(([k, v]) => ({ name: k, y: v }))
                }]
            });
        }

        // --- Render Referring Health Facility Bar ---
        if (document.getElementById("chart-referring-facility")) {
            Highcharts.chart("chart-referring-facility", {
                chart: { type: "bar" },
                title: { text: "Referring Health Facility" },
                xAxis: { categories: Object.keys(facilityCounts) },
                yAxis: { title: { text: "Number of Referrals" } },
                series: [{
                    name: "Referrals",
                    data: Object.values(facilityCounts)
                }]
            });
        }
    }

    function updateICDSection(data) {
        let icdCounts = {};

        // Flatten referrals from all hospitals
        let allReferrals = [];
        data.forEach(h => {
            if (Array.isArray(h.referrals)) {
                allReferrals = allReferrals.concat(h.referrals);
            }
        });

        // Count ICD codes
        allReferrals.forEach(r => {
            let code = r.icd_diagnosis || "Unknown";
            let title = r.icd_diagnosis_title || "Unknown Diagnosis";

            if (!icdCounts[code]) {
                icdCounts[code] = { code, title, count: 0 };
            }
            icdCounts[code].count++;
        });

        // Convert object to array and sort by count
        let icdArray = Object.values(icdCounts).sort((a, b) => b.count - a.count);

        // --- Update ICD DataTable ---
        if ($.fn.DataTable.isDataTable("#icdTable")) {
            $("#icdTable").DataTable().clear().rows.add(icdArray).draw();
        } else {
            $("#icdTable").DataTable({
                data: icdArray,
                columns: [
                    { data: "code", title: "ICD Code" },
                    { data: "title", title: "ICD Title" },
                    { data: "count", title: "Count" }
                ],
                pageLength: 10,
                responsive: true,
                autoWidth: false,
                searching: true,
                ordering: true,
                order: [[2, "desc"]]
            });
        }

        // --- Top 10 ICD Chart ---
        let top10 = icdArray.slice(0, 10);

        if (document.getElementById("icdChart")) {
            Highcharts.chart("icdChart", {
                chart: { type: "column" },
                title: { text: "Top 10 ICD Diagnoses" },
                xAxis: {
                    categories: top10.map(i => i.code),
                    title: { text: "ICD Code" }
                },
                yAxis: {
                    min: 0,
                    title: { text: "Number of Referrals" }
                },
                series: [{
                    name: "Referrals",
                    data: top10.map(i => i.count)
                }],
                tooltip: {
                    formatter: function () {
                        let icd = top10[this.point.index];
                        return `<b>${icd.code}</b>: ${icd.title}<br>Count: ${icd.count}`;
                    }
                }
            });
        }
    }

    function updateRHUSection(data) {
        let summary = {};

        // Flatten referrals
        data.forEach(h => {
            if (!Array.isArray(h.referrals)) return;
            h.referrals.forEach(r => {
                let facility = r.referred_by || "Unknown Facility";
                let service = (r.type || "Unknown").toUpperCase(); // ER, OB, PCR, etc.
                let level = (r.pat_class || "Primary").toLowerCase(); // primary, secondary, tertiary

                if (!summary[facility]) {
                    summary[facility] = {
                        ER: { primary: 0, secondary: 0, tertiary: 0 },
                        OB: { primary: 0, secondary: 0, tertiary: 0 },
                        PCR: { primary: 0, secondary: 0, tertiary: 0 },
                        TOXICOLOGY: { primary: 0, secondary: 0, tertiary: 0 },
                        CANCER: { primary: 0, secondary: 0, tertiary: 0 },
                        OPD: { primary: 0, secondary: 0, tertiary: 0 },
                        total: 0
                    };
                }

                // Ensure service type exists
                if (!summary[facility][service]) {
                    summary[facility][service] = { primary: 0, secondary: 0, tertiary: 0 };
                }

                if (["primary", "secondary", "tertiary"].includes(level)) {
                    summary[facility][service][level]++;
                    summary[facility].total++;
                }
            });
        });

        // Convert to array for table
        let rows = Object.entries(summary).map(([facility, s]) => {
            return {
                facility,
                ER: [s.ER.primary, s.ER.secondary, s.ER.tertiary],
                OB: [s.OB.primary, s.OB.secondary, s.OB.tertiary],
                PCR: [s.PCR.primary, s.PCR.secondary, s.PCR.tertiary],
                Toxicology: [s.TOXICOLOGY.primary, s.TOXICOLOGY.secondary, s.TOXICOLOGY.tertiary],
                Cancer: [s.CANCER.primary, s.CANCER.secondary, s.CANCER.tertiary],
                OPD: [s.OPD.primary, s.OPD.secondary, s.OPD.tertiary],
                total: s.total
            };
        });

        // ✅ Sort rows by total (descending)
        rows.sort((a, b) => b.total - a.total);

        // --- Fill Table ---
        let tbody = $("#rhuTable tbody");
        tbody.empty();

        rows.forEach(r => {
            let rowHtml = `
                <tr>
                    <td>${r.facility}</td>
                    <td>${r.ER[0]}</td><td>${r.ER[1]}</td><td>${r.ER[2]}</td>
                    <td>${r.OB[0]}</td><td>${r.OB[1]}</td><td>${r.OB[2]}</td>
                    <td>${r.PCR[0]}</td><td>${r.PCR[1]}</td><td>${r.PCR[2]}</td>
                    <td>${r.Toxicology[0]}</td><td>${r.Toxicology[1]}</td><td>${r.Toxicology[2]}</td>
                    <td>${r.Cancer[0]}</td><td>${r.Cancer[1]}</td><td>${r.Cancer[2]}</td>
                    <td>${r.OPD[0]}</td><td>${r.OPD[1]}</td><td>${r.OPD[2]}</td>
                    <td><b>${r.total}</b></td>
                </tr>
            `;
            tbody.append(rowHtml);
        });
    }

    function populateRHUSelect() {
        $.ajax({
            url: "../../assets/php/patient_registration_form/get_hospitals.php",
            type: "GET",
            dataType: "json",
            success: function (data) {
                
                let hospitalSelect = $("#rhu-select");
                hospitalSelect.empty();

                // Always include "All" first
                hospitalSelect.append('<option value="">All</option>');

                // Put BGHMC first as default
                // hospitalSelect.append('<option value="1111" selected>Bataan General Hospital and Medical Center</option>');

                // Append the rest
                data.forEach(hospital => {
                    if (hospital.hospital_name !== "Bataan General Hospital and Medical Center") {
                        hospitalSelect.append(
                            `<option value="${hospital.hospital_name}">${hospital.hospital_name}</option>`
                        );
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("Failed to load hospitals:", error);
            }
        });
    }


    // 🔹 Filter form submit
    $("#filterForm").on("submit", function (e) {
        e.preventDefault();

        let formData = $(this).serialize(); // Collects all inputs (startDate, endDate, caseType, rhu)
        console.table(formData)
        fetch_incoming(formData); // Pass it to fetch_incoming
    });

    // 🔹 Modified fetch_incoming
    function fetch_incoming(formData = "") {
        $.ajax({
            url: "../../assets/php/dashboard_incoming/fetch_dashboard_incoming.php",
            type: "GET",
            data: formData, // pass filters here
            dataType: "json",
            success: function (response) {
                console.table(response);
                if (Array.isArray(response)) {
                    updateAverages(response);
                    updateCharts(response);
                    updateICDSection(response);
                    updateRHUSection(response);
                } else {
                    console.warn("Unexpected response format:", response);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                console.log(xhr.responseText);
            }
        });
    }

    fetch_incoming();
    populateRHUSelect();

    // $("#filterForm").on("submit", function (e) {
    //     e.preventDefault();

    //     let formData = $(this).serialize(); // grabs all inputs (date, case type, RHU)

    //     $.ajax({
    //         url: "../../assets/php/dashboard_incoming/fetch_dashboard_incoming.php", // adjust path as needed
    //         method: "GET",
    //         data: formData,
    //         dataType: "json",
    //         success: function (response) {
    //             if (response.success) {
    //                 let data = response.data;

    //                 // ✅ Update each section with filtered data
    //                 updateAveragesSection(data);
    //                 updateChartsSection(data);
    //                 updateICDSection(data);
    //                 updateRHUSection(data);
    //             } else {
    //                 console.error("Error:", response.message);
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error("AJAX Error:", error);
    //         }
    //     });
    // });
});
