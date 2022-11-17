<?php

namespace Dukrl\Template_method\Example;

abstract class Email
{
    protected $mail;
    protected $password;

    public function __construct(string $mail, string $password)
    {
        $this->mail = $mail;
        $this->password = $password;
    }

    public function GoAction(string $message): bool
    {
        if ($this->Login($this->mail, $this->password)) {
            $result = $this->Send($message);
            $this->Logout();

            return $result;
        }

        return false;
    }

    abstract public function Login(string $mail, string $password): bool;

    abstract public function Send(string $message): bool;

    abstract public function Logout(): void;
}


class Gmail extends Email
{
    public function Login(string $mail, string $password): bool
    {
        echo "\nConfirmando as credenciais de acesso do usuário\n";
        echo "email: " . $this->mail . "\n";
        echo "senha: " . str_repeat("*", strlen($this->password)) . "\n";

        echo "\n\nGmail: '" . $this->mail . "' efetuou o login com sucesso.\n";

        return true;
    }

    public function Send(string $message): bool
    {
        echo "Gmail: '" . $this->mail . "' enviou a seguinte mensagem: '" . $message . "'.\n";

        return true;
    }

    public function Logout(): void
    {
        echo "Logout efetuado com sucesso.\n";
    }
}

class Outlook extends Email
{
    public function Login(string $mail, string $password): bool
    {
        echo "\nConfirmando as credenciais de acesso do usuário\n";
        echo "email: " . $this->mail . "\n";
        echo "senha: " . str_repeat("*", strlen($this->password)) . "\n";

        echo "\n\nOutlook: '" . $this->mail . "' efetuou o login com sucesso.\n";

        return true;
    }

    public function Send(string $message): bool
    {
        echo "Outlook: '" . $this->mail . "' enviou a seguinte mensagem: '" . $message . "'.\n";

        return true;
    }

    public function Logout(): void
    {
        echo "Logout efetuado com sucesso.\n";
    }
}

function run() {

    echo "\nSelecione o email pelo qual deseja enviar:\n" .
        "1 - Gmail\n" .
        "2 - Outlook\n";
    $choice = readline();

    if ($choice == 1) {
        echo "Gmail selecionado, digite seu email de acesso: \n";
        $mail = readline();

        if (!strpos($mail, 'gmail')) {
            echo "Esse email não é valido para essa opção. Selecione a opção correta e tente novamente!";
            run();

            return;
        }

        echo "\nDigite sua senha:\n";
        $password = readline();

        echo "\n Digite a mensagem que deseja enviar: \n";
        $message = readline();

        $connect = new Gmail($mail, $password);

    } elseif ($choice == 2) {
        echo "Outlook selecionado, digite seu email de acesso: \n";
        $mail = readline();

        if (!strpos($mail, 'outlook')) {
            echo "Esse email não é valido para essa opção. Selecione a opção correta e tente novamente!";
            run();

            return;
        }

        echo "\nDigite sua senha:\n";
        $password = readline();

        echo "\n Digite a mensagem que deseja enviar: \n";
        $message = readline();

        $connect = new Outlook($mail, $password);
    } else {
        die("Nenhuma das opções corretas selecionadas. F total.\n");
    }

    $connect->GoAction($message);
}

run();
