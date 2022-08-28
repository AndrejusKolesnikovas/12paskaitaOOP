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
php -f 4todo.php add "nuplauti automobilų" "2022-03-29 15:00"
todo added!
------------------------------------------------------------------------
php -f 4todo.php list
****
id: 1
nuplauti automobili
2022-03-29 15:00
------------------------------------------------------------------------
php -f 4todo.php add "apsilankymas pas kirpeją" "2022-04-15 12:00"
todo added!
------------------------------------------------------------------------
php -f 4todo.php list
****
id: 1
nuplauti automobilų
2022-03-29 15:00
****
id: 2
apsilankymas pas kirpeją
2022-04-15 12:00
------------------------------------------------------------------------
php -f 4todo.php complete 1
todo completed!
------------------------------------------------------------------------
*/

// $argv yra specialus kintamasis, i kuri PHP sudeda vykdomo failo argumentus
class todoApp
{
    public function run(array $argv): void
    {
        $operationType = $argv[1];
        if ($operationType === 'add') {
            $task = $argv[2];
            $date = $argv[3];

            $todo = ['task' => $task, 'date' => $date, 'is_completed' => false];

            $this->addTodo($todo);
            echo 'todo added!';

        } elseif ($operationType === 'list') {
            $this->listTodo();

        } elseif ($operationType === 'complete') {
            $this->completeTodos($argv[2]);

//            if (isset($data[$enterID])) {
//                showDataOne($enterID, $data[0]);
//            } else {
//                echo 'Vehicle ' . $enterID . ' does not exist!';
//            }
        }
    }

    private function addTodo(array $todo): void
    {

        $todos = $this->loadAllTodos();
        // prideti nauja uzduoti prie esamu
        $todos[] = $todo;
        // issaugoti
        file_put_contents('./tasks.json', json_encode($todos, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));
    }

    private function listTodo(): void
    {
        $todos = $this->loadAllTodos();
        foreach ($todos as $key => $item) {
            $isCompleted = $item['is_completed'] ? 'Yes' : 'No';
            echo '****' . PHP_EOL . 'id: ' . $key . PHP_EOL .
                'task: ' . $item['task'] . PHP_EOL .
                'date: ' . $item['date'] . PHP_EOL .
                'is_completed: ' . $isCompleted . PHP_EOL;
        };
    }

    private function loadAllTodos(): array
    {
        $data = file_get_contents('./tasks.json');
        return json_decode($data, true);
    }

    private function completeTodos($id): void
    {
        $todos = $this->loadAllTodos();

        if (isset($todos[$id])) {
            $todos[$id]['is_completed'] = true;
            // issaugoti
            file_put_contents('./tasks.json', json_encode($todos, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));

            echo 'todo completed!';
        } else {
            echo 'Task ' . $id . ' does not exist!';
        }

    }
}

$todoApp = new todoApp();
$todoApp->run($argv);