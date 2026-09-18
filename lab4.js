// ==========================================
// 1. IIFE (Негайно викликаний функціональний вираз)
// ==========================================
(function() {
    console.log("--- Завдання 1: IIFE ---");
    console.log("Поточний URL сторінки:", window.location.href);
})();


// ==========================================
// 2. Методи роботи з масивами: map, filter, reduce
// ==========================================
console.log("\n--- Завдання 2: Методи масивів ---");

// a. Створення масиву з 10+ елементів
const numbers = [5, 12, 18, 22, 30, 45, 10, 3, 50, 27];
console.log("Початковий масив:", numbers);

// b. Метод map (подвоєння кожного числа)
const doubled = numbers.map(num => num * 2);
console.log("Подвоєні числа (map):", doubled);

// c. Метод filter (лише числа більше 25)
const greaterThan25 = numbers.filter(num => num > 25);
console.log("Числа більше 25 (filter):", greaterThan25);

// d. Метод reduce (сума всіх елементів початкового масиву)
const sumOfNumbers = numbers.reduce((total, num) => total + num, 0);
console.log("Сума всіх елементів (reduce):", sumOfNumbers);


// ==========================================
// 3. Оператор Spread у функції
// ==========================================
console.log("\n--- Завдання 3: Spread оператор ---");

// a. Функція multiply, яка приймає два параметри і повертає добуток
function multiply(a, b) {
    return a * b;
}

// b. Масив із двома елементами
const pair = [7, 8];

// c. Виклик за допомогою Spread оператора та виведення в консоль
const product = multiply(...pair);
console.log(`Добуток чисел ${pair[0]} та ${pair[1]} (spread):`, product);


// ==========================================
// 4. Робота з Set
// ==========================================
console.log("\n--- Завдання 4: Структура даних Set ---");

// a. Створення Set із дублікатами
const mySet = new Set([10, 20, 20, 30, 40, 50, 10, 30]);
console.log("Об'єкт Set (дублікати видалено автоматично):", mySet);

// b. Виведення елементів за допомогою циклу for-of
console.log("Елементи Set через цикл for-of:");
for (const value of mySet) {
    console.log(value);
}


// ==========================================
// 5. Використання методу bind для прив'язки контексту
// ==========================================
console.log("\n--- Завдання 5: Метод bind ---");

// a. Об'єкт user з методом getName
const user = {
    name: 'Олександр',
    getName: function() {
        console.log(`Користувач: ${this.name}`);
    }
};

// b. Об'єкт admin з іншою властивістю name
const admin = {
    name: 'Адміністратор Софія'
};

// c. Прив'язка методу user.getName до об'єкта admin через bind
const adminGetName = user.getName.bind(admin);
adminGetName(); // Виведе ім'я адміністратора


// ==========================================
// 6. Створення функції із замиканням (closure)
// ==========================================
console.log("\n--- Завдання 6: Замикання (Closure) ---");

// a, b, c. Функція createAdvancedCounter із методами increment та decrement
function createAdvancedCounter() {
    let count = 0; // Змінна стану, захищена замиканням

    return {
        increment: function() {
            count++;
            console.log(`Збільшено. Поточний лічильник: ${count}`);
            return count;
        },
        decrement: function() {
            count--;
            console.log(`Зменшено. Поточний лічильник: ${count}`);
            return count;
        }
    };
}

const counter = createAdvancedCounter();
counter.increment(); // 1
counter.increment(); // 2
counter.decrement(); // 1