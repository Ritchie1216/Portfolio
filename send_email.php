<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 引入PHPMailer的自动加载文件
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // 初始化 PHPMailer
    $mail = new PHPMailer(true);

    try {
        // 服务器设置
        $mail->isSMTP();                                            // 设置邮件发送为 SMTP
        $mail->Host = 'smtp.gmail.com';                               // 使用 Gmail 的 SMTP 服务器
        $mail->SMTPAuth = true;                                       // 启用 SMTP 身份验证
        $mail->Username = 'ritchie121600@gmail.com';                     // 你的 Gmail 邮箱地址
        $mail->Password = 'oybzzjmsdpgvytvp';                      // 你的 Gmail 密码（或生成的 App 密码）
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // 启用 TLS 加密
        $mail->Port = 587;                                            // SMTP 端口号，587 是 Gmail SMTP 的端口

        // 发件人信息
        $mail->setFrom($email, $username);                            // 发件人邮箱和名称
        $mail->addAddress('ritchie121600@gmail.com', 'Recipient Name'); // 收件人邮箱地址

        // 邮件内容
        $mail->isHTML(true);                                          // 设置邮件格式为 HTML
        $mail->Subject = 'New Contact Form Submission: ' . $subject;
        $mail->Body    = "You have received a new message from the contact form.<br><br>" . 
                         "Username: $username<br>" .
                         "Email: $email<br>" .
                         "Message: $message<br>";

        // 发送邮件
        $mail->send();

        // 发送成功后重定向到 index.html 并传递 success 参数
        echo "<script>
                window.location.href = 'index.html?message=Message sent successfully!';
              </script>";
    } catch (Exception $e) {
        // 发送失败后重定向到 index.html 并传递 error 参数
        echo "<script>
                window.location.href = 'index.html?message=Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
              </script>";
    }
}
?>
