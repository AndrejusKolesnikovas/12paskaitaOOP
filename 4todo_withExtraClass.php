<?php

declare(strict_types=1);

/*
Sukurkite paprastą uzduociu aplikaciją. Naudokite objektinį programavimą. Aplikacija turi turėti 3 funkcijas:
- add - pridėti naują uzduoti
- list - atvaizduoti visas uzduotis
- complete - pažymėti kažkurį uzduoti kaip padarytą. Padarytas uzduotis galima arba trinti, arba pridėti požymį "completed"
Koda rasykite objektiskai (OOP).
Duomenys galetu buti saugomi faile siuo formatu:
{
    "0": {
        "task": "nuplauti masina",
        "date": "2021-01-01",
        "is_completed": false
    }
}

Aplikacijos kvietimo pavyzdžiai:
------------------------------------------------------------------------
php -f todo.php add "nuplauti automobilų" "2022-03-29 15:00"
todo added!
------------------------------------------------------------------------
php -f todo.php list
****
id: 1
nuplauti automobili
2022-03-29 15:00
------------------------------------------------------------------------
php -f todo.php add "apsilankymas pas kirpeją" "2022-04-15 12:00"
todo added!
------------------------------------------------------------------------
php -f todo.php list
****
id: 1
nuplauti automobilų
2022-03-29 15:00
****
id: 2
apsilankymas pas kirpeją
2022-04-15 12:00
------------------------------------------------------------------------
php -f todo.php complete 1
todo completed!
------------------------------------------------------------------------
*/

// $argv yra specialus kintamasis, i kuri PHP sudeda vykdomo failo argumentus

class FileRepository
{
    public function __construct(private string $filePath)
    {
    }

    public function loadAll(): array
    {
        $fileData = file_get_contents($this->filePath);
        return json_decode($fileData, true);
    }

    public function saveData(array $data): void
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));
    }
}

class TodoApp
{
    private $fileRepository;

    public function __construct()
    {
        $this->fileRepository = new FileRepository('./todo.json');
    }

    public function run(array $argv): void
    {
        $operationType = $argv[1];
        if ($operationType === 'add') {
            $todo = [
                'task' => $argv[2],
                'date' => $argv[3],
                'is_completed' => false,
            ];
            $this->addTodo($todo);
        } else if ($operationType === 'list') {
            $this->listTodos();
        } else if ($operationType === 'complete') {
            $this->complete((int)$argv[2]);
        }
    }

    private function addTodo(array $todo): void
    {
        // uzkrauti uzduotis is failo
        $todos = $this->fileRepository->loadAll();
        // prideti nauja uzduoti prie esamu
        $todos[] = $todo;
        // issaugoti
        $this->fileRepository->saveData($todos);
    }

    private function listTodos(): void
    {
        $todos = $this->fileRepository->loadAll();
        foreach ($todos as $id => $todo) {
            $isCompleted = $todo['is_completed'] ? 'Yes' : 'No';
            echo '***' . PHP_EOL;
            echo 'id: ' . $id . PHP_EOL;
            echo 'type: ' . $todo['task'] . PHP_EOL;
            echo 'name: ' . $todo['date'] . PHP_EOL;
            echo 'is completed: ' . $isCompleted . PHP_EOL;
        }
    }

    private function complete(int $id): void
    {
        // uzsiloadinti visas uzduotis
        $todos = $this->fileRepository->loadAll();
        // paimti uzduoti pagal ID ir pakeisti jos is_completed i true
        if (isset($todos[$id])) {
            $todos[$id]['is_completed'] = true;
            // issaugoti visas uzduotis
            $this->fileRepository->saveData($todos);
        }
    }
}


$todoApp = new TodoApp();
$todoApp->run($argv);