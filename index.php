<?php
    // Message Var
    $msg = '';
    $msgClass = '';
    //check for submit
    if(filter_has_var(INPUT_POST,'submit')){
        //Form Data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        //required field
        if(!empty($email) && !empty($name) && !empty($message)){
            //passed
            // check email
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                // failed
                $msg = 'Please use a valid email';
                $msgClass = 'alert-danger';
            }else{
                //passed
                // Enter recipient Email
                $toEmail = ' ';
                //Subject
                $subject = 'Contact Request From'.$name;
                //Body
                $body = '<h2>Contact Request</h2>
                    <h4>Name</h4><p>'.$name.'</p>
                    <h4>Email</h4><p>'.$email.'</p>
                    <h4>Message</h4><p>'.$message.'</p>
                ';
                //Email Header
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8"."\r\n";

                //Additional Headers
                $headers = "From". $name ."<" .$email.">". "\r\n";
                
                if(mail($toEmail, $subject, $body, $headers)){
                    //Email sent
                    $msg = 'Your Email has been sent';
                    $msgClass = 'alert-success';
                }else{
                      //Email not sent
                    $msg = 'Your Email was not sent';
                    $msgClass = 'alert-danger';
                }

            }
        }else{
            //Failed
            $msg = 'Please fill in all fields';
            $msgClass = 'alert-danger';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN LINK -->
    <link rel="stylesheet" href="https://bootswatch.com/5/cosmo/bootstrap.min.css">
    <title>Contact Us</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">My Website</a>
        </div>
    </nav> 
    <div class="container mt-4">
        <?php if($msg != ''):?>
            <div class="alert <?php echo $msgClass; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : '';?>">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : '';?>">
            </div>
            <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : '';?></textarea>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>