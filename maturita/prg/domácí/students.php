<?php
class Student {
    public string $name;
    public array $grades;
    public int $attendance;

        public function __construct(string $name, array $grades, int $attendance) {
            $this->name = $name;
            $this->grades = $grades;
            $this->attendance = $attendance;
        }

        public function getAverage():float{
            return array_sum($this->grades) / count($this->grades);
        }

        public function isDoingWell():bool{
            return $this->getAverage()<=2.0 &&  $this->attendance >= 70;
        }
    }
    $jsonText=file_get_contents('students.json');
    $jsonData=json_decode( $jsonText, true);                                     
    $class=[];
    foreach ($jsonData as $student){
        $class[]= new Student (
                $student['name'],
                $student['grades'],
                $student['attendance']
        );
    }

    usort ($class, function($a,$b){
        return $a->getAverage() <=> $b->getAverage();
    });
    foreach($class as $student){
        if ($student->getAverage()<1.5){
            echo $student->name . "<br>";
        }
    }

    $json=json_encode($class, JSON_PRETTY_PRINT);
    file_put_contents('sortedStudents.json', $json);
    
?>