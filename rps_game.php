<?php

/**
 * Функція валідації вхідних даних гравця (перевірка, чи це 0, 1, 2 або 3 для виходу)
 */
function validate($inputParam): bool {
    return in_array($inputParam, ['0', '1', '2', '3'], true);
}

/**
 * Основна логіка гри "Камінь, Ножиці, Папір" на 3 раунди з можливістю виходу
 */
function playRPSGame(): void {
    $options = ['камінь', 'ножиці', 'папір'];
    $userScore = 0;
    $computerScore = 0;
    $rounds = 3;

    echo "=== Гра: Камінь, Ножиці, Папір (3 раунди) ===\n";

    // Анонімна функція для випадкового вибору комп'ютера
    $getComputerChoice = function() use ($options) {
        return $options[array_rand($options)];
    };

    for ($round = 1; $round <= $rounds; $round++) {
        echo "\nРаунд $round. Обери:\n";
        echo "[0] камінь\n";
        echo "[1] ножиці\n";
        echo "[2] папір\n";
        echo "[3] Вийти з гри\n";
        echo "-> ";

        $input = trim(fgets(STDIN));

        // Валідація введених даних
        if (!validate($input)) {
            echo "Помилка! Будь ласка, введіть цифру від 0 до 3.\n";
            $round--; // Повторюємо раунд у разі невірного введення
            continue;
        }

        $userChoiceIndex = (int)$input;

        // Перевірка на вихід з гри (клавіша 3)
        if ($userChoiceIndex === 3) {
            echo "\nВи достроково вийшли з гри.\n";
            return;
        }

        $userChoice = $options[$userChoiceIndex];
        $computerChoice = $getComputerChoice();

        echo "Ти вибрав: $userChoice\n";
        echo "Я вибрав: $computerChoice\n";

        // Визначення переможця раунду
        if ($userChoice === $computerChoice) {
            echo "Нічия у цьому раунді!\n";
        } elseif (
            ($userChoice === 'камінь' && $computerChoice === 'ножиці') ||
            ($userChoice === 'ножиці' && $computerChoice === 'папір') ||
            ($userChoice === 'папір' && $computerChoice === 'камінь')
        ) {
            echo "Ти виграв цей раунд!\n";
            $userScore++;
        } else {
            echo "Комп'ютер виграв цей раунд!\n";
            $computerScore++;
        }

        echo "Рахунок -> Гравець: $userScore | Комп'ютер: $computerScore\n";
    }

    // Оголошення загального переможця після 3 раундів
    echo "\n===============================\n";
    echo "КІНЕЦЬ ГРИ! Загальний рахунок:\n";
    echo "Гравець: $userScore | Комп'ютер: $computerScore\n";

    if ($userScore > $computerScore) {
        echo "Вітаю! Ти переміг у всій грі!\n";
    } elseif ($userScore < $computerScore) {
        echo "На жаль, комп'ютер переміг у грі.\n";
    } else {
        echo "Нічия за підсумками трьох раундів!\n";
    }
}

// Запуск гри
playRPSGame();

?>