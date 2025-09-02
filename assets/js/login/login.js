$(document).ready(function () {
    $("#login-form").submit(function(e){
        e.preventDefault(); // prevent form from submitting normally

        $.ajax({
            url: "../../assets/php/login/login_process.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response){
                if(response.success){
                    $("#login-response").html(
                        `<p style="color: #333333; font-weight: 300; background: #e6ffe6; padding: 10px; border: 1px solid #66cc66; border-radius: 6px; text-align: center; font-size:0.7rem;">
                            ✅ Welcome ${response.fullname}! Redirecting...
                        </p>`
                    );
                    // redirect after 1.5s
                    setTimeout(function(){
                        window.location.href = "dashboard.php";
                    }, 1500);
                } else {
                    $("#login-response").html(
                        `<p style="color:red;">${response.message}</p>`
                    );
                }
            },
            error: function(){
                $("#login-response").html(
                    `<p style="color:red;">Something went wrong, please try again.</p>`
                );
            }
        });
    });
});
