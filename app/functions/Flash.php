<?php
namespace app\functions;


class Flash
{

    /**
     * Inclui a menssagem de erro no flash
     */
    public static function addMenssagem($message, $type = 'success', $code = 200)
    {
        $flash = [
            "message" => $message,
            "type" => $type,
            "code" => $code
        ];
        $flash = json_encode($flash);
        setcookie("flash", $flash, time()+3600);
    }

    /**
     * Exibe a menssagem de do flash
     */
    public static function showMenssagem() {
        if (isset($_COOKIE["flash"])) {
            $flash = json_decode($_COOKIE["flash"]);
            $message = $flash->message;
            $type = $flash->type;
            setcookie( "flash", "", time()- 60, "/","", 0);
            return "<div class='alert alert-$type flash' role='alert'>$message</div>";
        }
    }

}
?>