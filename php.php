<?php

class AddressIPv4 implements IAddressIPv4
{
    private $address;
    private $octets;

    // Konstruktor
    public function __construct(string $address)
    {
        $this->set($address);
    }

    // Validace IPv4 adresy
    public function isValid(): bool
    {
        // Kontrola pomocí filter_var s filtrem pro IP adresy
        return filter_var($this->address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    // Nastavení nové IPv4 adresy
    public function set(string $address): IAddressIPv4
    {
        $this->address = $address;
        $this->octets = explode('.', $address); // Rozdělení adresy na oktety
        return $this;
    }

    // Vrácení adresy jako řetězce
    public function getAsString(): string
    {
        return $this->address;
    }

    // Vrácení adresy jako integer
    public function getAsInt(): int
    {
        // Převedení adresy na integer
        $octets = array_map('intval', $this->octets);
        return ($octets[0] << 24) + ($octets[1] << 16) + ($octets[2] << 8) + $octets[3];
    }

    // Vrácení adresy jako binární řetězec
    public function getAsBinaryString(): string
    {
        // Převedení každého oktetu na binární hodnotu
        $binaryString = '';
        foreach ($this->octets as $octet) {
            $binaryString .= str_pad(decbin($octet), 8, '0', STR_PAD_LEFT);
        }
        return $binaryString;
    }

    // Vrácení určitého oktetu podle čísla (1-4)
    public function getOctet(int $number): int
    {
        if ($number < 1 || $number > 4) {
            throw new InvalidArgumentException("Octet number must be between 1 and 4.");
        }
        return intval($this->octets[$number - 1]);
    }

    // Určení třídy IP adresy
    public function getClass(): string
    {
        $firstOctet = intval($this->octets[0]);

        if ($firstOctet >= 1 && $firstOctet <= 126) {
            return 'A';
        } elseif ($firstOctet >= 128 && $firstOctet <= 191) {
            return 'B';
        } elseif ($firstOctet >= 192 && $firstOctet <= 223) {
            return 'C';
        } elseif ($firstOctet >= 224 && $firstOctet <= 239) {
            return 'D';
        } elseif ($firstOctet >= 240 && $firstOctet <= 255) {
            return 'E';
        } else {
            return 'Unknown';
        }
    }

    // Kontrola, zda je adresa privátní
    public function isPrivate(): bool
    {
        $firstOctet = intval($this->octets[0]);
        $secondOctet = intval($this->octets[1]);

        // Privátní rozsahy
        if (($firstOctet == 10) ||
            ($firstOctet == 172 && $secondOctet >= 16 && $secondOctet <= 31) ||
            ($firstOctet == 192 && $secondOctet == 168)) {
            return true;
        }
        return false;
    }
}

// Ukázka použití třídy AddressIPv4

$ip1 = new AddressIPv4("192.168.1.1");
echo "IP adresa: " . $ip1->getAsString() . PHP_EOL;
echo "Je validní: " . ($ip1->isValid() ? 'Ano' : 'Ne') . PHP_EOL;
echo "Jako integer: " . $ip1->getAsInt() . PHP_EOL;
echo "Jako binární řetězec: " . $ip1->getAsBinaryString() . PHP_EOL;
echo "Třetí oktet: " . $ip1->getOctet(3) . PHP_EOL;
echo "Třída adresy: " . $ip1->getClass() . PHP_EOL;
echo "Je privátní: " . ($ip1->isPrivate() ? 'Ano' : 'Ne') . PHP_EOL;

$ip2 = new AddressIPv4("8.8.8.8");
echo PHP_EOL . "IP adresa: " . $ip2->getAsString() . PHP_EOL;
echo "Je validní: " . ($ip2->isValid() ? 'Ano' : 'Ne') . PHP_EOL;
echo "Třída adresy: " . $ip2->getClass() . PHP_EOL;
echo "Je privátní: " . ($ip2->isPrivate() ? 'Ano' : 'Ne') . PHP_EOL;
