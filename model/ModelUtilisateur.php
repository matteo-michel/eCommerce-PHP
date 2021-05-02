<?php
require_once File::build_path(array('model', 'Model.php'));

class modelUtilisateur extends Model {

    private $login;
    private $nom;
    private $prenom;
    private $password;
    private $email;
    private $isAdmin;
    private $nonce;

    protected static $object = 'utilisateur';
    protected static $primary = 'login';

    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public function set($nom_attribut, $valeur) {
        if (property_exists($this, $nom_attribut))
            $this->$nom_attribut = $valeur;
        return false;
    }

    public function __construct($login = NULL, $nom = NULL, $prenom = NULL, $password = NULL, $email = NULL, $isAdmin = NULL) {
        if (!is_null($login) && !is_null($nom) && !is_null($prenom) && !is_null($password) && !is_null($email) && !is_null($isAdmin)) {
            $this->login = $login;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->password = $password;
            $this->email = $email;
            $this->isAdmin = $isAdmin;
        }
    }

    public static function testLogin($login)
    {
        try {
        $sql="SELECT * from utilisateur WHERE login =:login";
        $req_prep = Model::$pdo->prepare($sql);
        $values = array("login"=>$login);
        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, "modelUtilisateur");
        $tab_voit=$req_prep->fetchAll();

        if(empty($tab_voit))return false;
        return$tab_voit[0];
      } catch (PDOException $e) {
        if (Conf::getDebug()) {
          echo $e->getMessage();
        } else {
          echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
        }
        die();
      }
    }
    public static function sendMail($login,$destinataire,$nonce)
    {
        $subject = 'Email de vérification Book\'Sell';
        $mail_link = 'http://localhost/index.php?controller=utilisateur&action=validate&login='.$login.'&nonce='.$nonce;
        $message =
            '<html>
                <body>
                    <strong>Bonjour,</strong>
                    <p>Votre inscription est presque terminée ! Confirmez votre adresse email en cliquant sur le lien ci-dessous :</p>
                        <a href="'.$mail_link.'" style="background-color: rgb(64,178,181); width: 250px; border: 1px solid rgb(64,178,181);border-radius: 4px; color: rgb(255, 255, 255); display: inline-block;">
                            Confirmer mon adresse email
                        </a>
                    <p>Si vous ne visualisez pas le bouton ci-dessus, veuillez cliquer <a href="'.$mail_link.'">içi</a></p>
                </body>
                </html>';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf8';
        $headers[] = 'From: Book\'Sell <BookSell@gmail.com>';

        mail($destinataire, $subject, $message, implode("\r\n", $headers));
    }

    public static function sendMailPassword($login,$destinataire, $nonce)
    {
        $subject = 'Email de vérification Book\'Sell';
        $mail_link = 'http://localhost/index.php?controller=utilisateur&action=endMidlle_forgotPassword&login='.$login.'&nonce='.$nonce;
        $message =
            '<html>
                <body>
                    <strong>Bonjour,</strong>
                    <p>Pour modifier votre mot de passe, confirmez votre adresse email en cliquant sur le lien ci-dessous :</p>
                        <a href="'.$mail_link.'" style="background-color: rgb(64,178,181); width: 250px; border: 1px solid rgb(64,178,181);border-radius: 4px; color: rgb(255, 255, 255); display: inline-block;">
                            Confirmer mon adresse email
                        </a>
                    <p>Si vous ne visualisez pas le bouton ci-dessus, veuillez cliquer <a href="'.$mail_link.'">içi</a></p>
                </body>
                </html>';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf8';
        $headers[] = 'From: Book\'Sell <BookSell@gmail.com>';

        mail($destinataire, $subject, $message, implode("\r\n", $headers));
    }

    public static function promote($login) {
        try {
            $sql="UPDATE utilisateur SET isAdmin='1' WHERE login = :login";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array("login"=>$login);
            $req_prep->execute($values);

        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

}
?>