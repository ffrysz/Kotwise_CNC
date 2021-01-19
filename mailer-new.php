<?php

    // Get the form fields, removes html tags and whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $surname = strip_tags(trim($_POST["surname"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $surname = str_replace(array("\r","\n"),array(" "," "),$surname);
    $phone = strip_tags(trim($_POST["phone"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $miejscowosc = $_POST["find-us"];
    if(isset($_POST["tak"])){
        $TUV = "Tak, poproszę.";
    } else{
        $TUV = "Nie, dziękuję.";
    };
    if(isset($_POST["RODO"])){
        $RODO = "Tak";
    } else{
        $RODO = "Nie, rezygnuję z procesu rekrutacji";
    }
    $message = trim($_POST["message"]);

    // Check the data.
    if (empty($name) OR empty($surname) OR empty($phone) OR empty($email) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: http://www.kotwise.pl?success=-1#form");
        exit;
    }

    // Set the recipient email address. Update this to YOUR desired email address.
    $recipient = "<biuro@kotwise.pl>";

    // Set the email subject.
    $subject = "Nowa aplikacja od $name $surname";

    // Build the email content.
    $email_content = "Imię: $name\n";
    $email_content .= "Nazwisko: $surname\n";
    $email_content .= "Adres email: $email\n";
    $email_content .= "Numer telefonu: $phone\n\n";
    $email_content .= "Miejscowość: $miejscowosc\n\n";
    $email_content .= "Certyfikat TUV: $TUV\n\n";
    $email_content .= "Wiadomość: $message\n\n";
    $email_content .= "Zapoznałem się z polityką prywatności i wyrażam zgodę na przetwarzanie moich danych osobowych w celach rekrutacyjnych: $RODO\n";

    // Build the email headers.
    $email_headers = "Od: $name <$email>";

    // Send the email.
    mail($recipient, $subject, $email_content, $email_headers);
    
    // Redirect to the index.html page with success code
    header("Location: http://www.kotwise.pl?success=1#form");

?>