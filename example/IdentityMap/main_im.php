<?php

class Student
{
    private $id;
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

class StudentIdentityMap
{
    private $studentCache = []; //ассоциативный массив, ключами которого являются ID студентов, а значениями - объекты студентов.

    // метод проверяет, есть ли студент с заданным ID в кэше.
    public function hasStudent(int $id): bool
    {
        return isset($this->studentCache[$id]);
    }

    //  возвращает студента с заданным ID из кэша, если таковой есть.
    public function getStudent(int $id): ?Student
    {
        return $this->studentCache[$id] ?? null;
    }
    // метод сохраняет студента в кэше.
    public function setStudent(int $id, Student $student): void
    {
        $this->studentCache[$id] = $student;
    }
}

    // получение данных о студенте из базы данных.
function fetchStudentFromDB(int $id): Student
{
    // Здесь обычно был бы код для получения данных из БД.
    // Сейчас просто вернем фейкового студента.
    return new Student($id, "Student" . $id);
}

// Создаем объект StudentIdentityMap для хранения кэша студентов.
$studentMap = new StudentIdentityMap();

// Получение студента с ID=1 из базы данных и сохранение его в кэше
if (!$studentMap->hasStudent(1)) {
    $student = fetchStudentFromDB(1);
    $studentMap->setStudent(1, $student);
} else {
    $student = $studentMap->getStudent(1);
}

echo "Student Name: " . $student->getName() . "\n";

// Получение того же студента из кэша, не обращаясь к БД
if (!$studentMap->hasStudent(1)) {
    $student = fetchStudentFromDB(1);
    $studentMap->setStudent(1, $student);
} else {
    $student = $studentMap->getStudent(1);
}

echo "Student Name: " . $student->getName() . "\n";