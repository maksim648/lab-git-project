// ==========================================
// 1. КЛАС BOOK (Книга)
// ==========================================
class Book {
    #title;
    #author;
    #isAvailable;

    constructor(title, author) {
        this.#title = title;
        this.#author = author;
        this.#isAvailable = true; // За замовчуванням книга доступна
    }

    get title() { return this.#title; }
    get author() { return this.#author; }
    get isAvailable() { return this.#isAvailable; }

    borrow() {
        if (this.#isAvailable) {
            this.#isAvailable = false;
            return true;
        }
        return false;
    }

    returnBook() {
        this.#isAvailable = true;
    }
}


// ==========================================
// 2. КЛАС USER (Базовий клас користувача)
// ==========================================
class User {
    #id;
    #name;
    #email;

    constructor(id, name, email) {
        this.#id = id;
        this.#name = name;
        this.#email = email;
    }

    get id() { return this.#id; }
    get name() { return this.#name; }
    get email() { return this.#email; }
}


// ==========================================
// 3. КЛАС LIBRARIAN (Бібліотекар - наслідує User)
// ==========================================
class Librarian extends User {
    #salary;

    constructor(id, name, email, salary) {
        super(id, name, email);
        this.#salary = salary;
    }

    get salary() { return this.#salary; }

    addBook(library, title, author) {
        const newBook = new Book(title, author);
        library.books.push(newBook);
        console.log(`[Бібліотекар ${this.name}] Додано нову книгу: "${title}" (${author})`);
    }

    removeBook(library, bookTitle) {
        const index = library.books.findIndex(b => b.title === bookTitle);
        if (index !== -1) {
            library.books.splice(index, 1);
            console.log(`[Бібліотекар ${this.name}] Видалено книгу: "${bookTitle}"`);
        } else {
            console.log(`[Бібліотекар ${this.name}] Книгу "${bookTitle}" не знайдено в бібліотеці.`);
        }
    }
}


// ==========================================
// 4. КЛАС READER (Читач - наслідує User)
// ==========================================
class Reader extends User {
    #membershipId;

    constructor(id, name, email, membershipId) {
        super(id, name, email);
        this.#membershipId = membershipId;
    }

    get membershipId() { return this.#membershipId; }

    borrowBook(library, bookTitle, daysToReturn = 14) {
        const book = library.books.find(b => b.title === bookTitle);
        
        if (!book) {
            console.log(`[Читач ${this.name}] Книги "${bookTitle}" немає в бібліотеці.`);
            return null;
        }

        if (!book.isAvailable) {
            console.log(`[Читач ${this.name}] Помилка: книга "${bookTitle}" вже знаходиться в користуванні.`);
            return null;
        }

        if (book.borrow()) {
            const dueDate = new Date();
            dueDate.setDate(dueDate.getDate() + daysToReturn); // Термін повернення

            const loan = new Loan(book, this, dueDate);
            library.loans.push(loan);
            console.gulf ? null : console.log(`[Читач ${this.name}] Успішно взяв книгу "${bookTitle}". Термін повернення: ${dueDate.toLocaleDateString()}`);
            return loan;
        }
    }

    returnBook(library, bookTitle) {
        const loanIndex = library.loans.findIndex(l => l.reader.id === this.id && l.book.title === bookTitle);
        
        if (loanIndex !== -1) {
            const loan = library.loans[loanIndex];
            loan.book.returnBook();
            library.loans.splice(loanIndex, 1);
            console.log(`[Читач ${this.name}] Успішно повернув книгу "${bookTitle}".`);
        } else {
            console.log(`[Читач ${this.name}] У вас немає активної позики на книгу "${bookTitle}".`);
        }
    }
}


// ==========================================
// 5. КЛАС LOAN (Позика книги)
// ==========================================
class Loan {
    #book;
    #reader;
    #dueDate;

    constructor(book, reader, dueDate) {
        this.#book = book;
        this.#reader = reader;
        this.#dueDate = dueDate;
    }

    get book() { return this.#book; }
    get reader() { return this.#reader; }
    get dueDate() { return this.#dueDate; }

    isOverdue() {
        return new Date() > this.#dueDate;
    }
}


// ==========================================
// 6. КЛАС LIBRARY (Головний клас управління)
// ==========================================
class Library {
    constructor() {
        this.books = [];
        this.users = [];
        this.loans = [];
    }

    addUser(user) {
        this.users.push(user);
        console.log(`[Library] Зареєстровано користувача: ${user.name}`);
    }

    showCatalog() {
        console.log("\n--- КАТАЛОГ БІБЛІОТЕКИ ---");
        this.books.forEach(b => {
            console.log(`- "${b.title}" (Автор: ${b.author}) | Доступна: ${b.isAvailable ? 'Так' : 'Ні'}`);
        });
        console.log("-------------------------\n");
    }
}


// ==========================================
// 7. ТЕСТОВІ СЦЕНАРІЇ (Перевірка роботи системи)
// ==========================================
console.log("=== ІНІЦІАЛІЗАЦІЯ СИСТЕМИ БІБЛІОТЕКИ ===");
const myLibrary = new Library();

// Створюємо бібліотекаря та читача
const librarian = new Librarian(1, "Анна Петрівна", "anna@lib.com", 15000);
const reader = new Reader(2, "Олександр Іванов", "oleksandr@gmail.com", "M-10023");

myLibrary.addUser(librarian);
myLibrary.addUser(reader);

// Бібліотекар додає нові книги
librarian.addBook(myLibrary, "Чистий код", "Роберт Мартін");
librarian.addBook(myLibrary, "Алгоритми. Посібник для розробників", "Брок Екарт");

myLibrary.showCatalog();

console.log("\n=== ТЕСТ 1: Успішна видача книги читачу ===");
const loan1 = reader.borrowBook(myLibrary, "Чистий код", 10);
myLibrary.showCatalog();

console.log("\n=== ТЕСТ 2: Помилка (спроба взяти вже зайняту книгу) ===");
const reader2 = new Reader(3, "Марія Коваль", "maria@gmail.com", "M-10024");
myLibrary.addUser(reader2);
reader2.borrowBook(myLibrary, "Чистий код"); // Повинно видати помилку

console.log("\n=== ТЕСТ 3: Повернення книги читачем ===");
reader.returnBook(myLibrary, "Чистий код");
myLibrary.showCatalog();

console.log("\n=== ТЕСТ 4: Видалення старої книги бібліотекарем ===");
librarian.removeBook(myLibrary, "Алгоритми. Посібник для розробників");
myLibrary.showCatalog();