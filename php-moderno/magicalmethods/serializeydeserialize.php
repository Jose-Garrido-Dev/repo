<?php

class User {
    public $name;
    private $email;
    private $password;

    public function __construct(string $name, string $email, string $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function __serialize(): array {
        return [
            'name' => strtoupper($this->name),
            'email' => $this->email,
            // no serializar password por seguridad
        ];
    }

    public function __unserialize(array $data): void {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = 'null'; // Asignar un valor por defecto
    }
}

$user = new User("Jose Garrido", "jose@example.com", "securepassword");
$s = serialize($user);
echo $s . "\n" . "<br>";

$obj = unserialize($s);

echo $obj->name;
print_r($obj);