<?php

/**
 * Функція валідації вхідних даних (перевірка, чи це ціле число від 1 до 100)
 */
function validate($inputParam): bool {
    // Перевіряємо, чи є введена строка числом і чи входить в діапазон 1-100
    return filter_var($inputParam, FILTER_VALIDATE_INT, [
        "options" => ["min_range" => 1, "max_range" => 100]
    ]) !== false;
}

/**
 * Основна логіка гри "Guess a Number"
 */
function playGame(int $maxAttempts = 7): void {
    $secretNumber = rand(1, 100);
    $attempts = 0;

    echo "Я загадав число від 1 до 100. Спробуй вгадати за $maxAttempts спроб.\n";

    // Анонімна функція для порівняння введеного числа із загаданим
    $compare = function(int $userGuess, int $secret) {
        if ($userGuess > $secret) {
            return "Спробуй менше.";
        } elseif ($userGuess < $secret) {
            return "Спробуй більше.";
        } else {
            return "Вітаю! Ти вгадав число!";
        }
    };

    while ($attempts < $maxAttempts) {
        $attempts++;
        echo "Спроба $attempts: ";
        
        $input = trim(fgets(STDIN));

        // Перевірка на вихід з гри або валідацію
        if (!validate($input)) {
            echo "Помилка! Будь ласка, введіть ціле число від 1 до 100.\n";
            $attempts--; // Не зараховуємо некоректну спробу
            continue;
        }

        $userGuess = (int)$input;
        $message = $compare($userGuess, $secretNumber);
        echo "$message\n";

        if ($userGuess === $secretNumber) {
            echo "Чудово! Тобі знадобилося спроб: $attempts\n";
            return;
        }
    }

    echo "\nНа жаль, твої спроби закінчилися. Я загадав число: $secretNumber\n";
}

// Запуск гри з 7 спробами
playGame(7);

?>