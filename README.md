Тестове завдання WordPress:

Усього потрібно 2 пост тайпу, і 2 ajax запиту
Зробити 1 сторінку, на сторінці вивести календар (FullCaledar) із подіями (PostType Events).
По кліку на подію зробити аякс запит, у відповідь отримати html (template-part) і відобразити в модальному вікні (назва події, дата (дата початку та дата завершення), картинка, форма запису з полями ім'я, телефон, емейл)

Надіслати форму ajax-ом, створити пост (PostType Lead). В адмінці створити custom MetaBox для сторінки запису ліда, в якому вивести інформацію про те, хто залишив заявку, та на яку подію. Також на сторінці з списком лідів в адмінці додати до поста CustomColumns, туди вивести також любу інформацію про лід (наприклад ім'я та телефон)

## встановлення

Потрібна батьківська тема twentytwentyfour  
Створіть папку теми twentytwentyfour-child

Встановіть плагін **ACF**  

імпортуйте базу данних яка знаходиться в папці **db**  

Клонуйте в папку twentytwentyfour-child код:  
    ```
    git clone https://github.com/Olegborodko/wp-test-19-06-2024.git
    ```

Permalink Settings встановіть в Post name  

Сторінка для запуску з Template - сalendar  

**Пароль та логін wp**  
admin  
111111  