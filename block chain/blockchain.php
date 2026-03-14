<?php
class Block {
    public $index;
    public $timestamp;
    public $data;
    public $previousHash;
    public $hash;

    public function __construct($index, $timestamp, $data, $previousHash = '') {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->previousHash = $previousHash;
        $this->hash = $this->calculateHash();
    }

    public function calculateHash() {
        return hash('sha256', $this->index . $this->previousHash . $this->timestamp . json_encode($this->data));
    }
}

class Blockchain {
    public $chain;

    public function __construct() {
        // Vytvoření prvního (Genesis) bloku
        $this->chain = [$this->createGenesisBlock()];
    }

    private function createGenesisBlock() {
        return new Block(0, date("Y-m-d H:i:s"), "Genesis Block", "0");
    }

    public function getLatestBlock() {
        return $this->chain[count($this->chain) - 1];
    }

    public function addBlock($newData) {
        $newBlock = new Block(
            count($this->chain),
            date("Y-m-d H:i:s"),
            $newData,
            $this->getLatestBlock()->hash
        );
        $this->chain[] = $newBlock;
    }

    public function isValid() {
        for ($i = 1; $i < count($this->chain); $i++) {
            $current = $this->chain[$i];
            $previous = $this->chain[$i - 1];

            if ($current->hash !== $current->calculateHash()) return false;
            if ($current->previousHash !== $previous->hash) return false;
        }
        return true;
    }
}