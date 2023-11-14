<?php
if($_SERVER['REQUEST_URI'] == '/index.php'){
    header('Location: /');
    exit();
}


$title = 'Home page';
ob_start(); ?>

<div class="container mt-5 bg-white p-4 rounded shadow">
    <h1 class="text-primary">CRM System</h1>

    <ul class="list-group mt-4">
        <li class="list-group-item bg-secondary text-white">
            <h4>CRUD capabilities</h4>
            <p>A central page showcasing a list of clients with the ability to Create, Read, Update, and Delete (CRUD) operations.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>Safe authentication</h4>
            <p>Authentication system requiring users to log in using stored credentials, ensuring secure access to the system.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>Super User</h4>
            <p>Upon successful login, users gain access to the system's features. Admin users receive additional privileges.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>Data models</h4>
            <p>Information is stored in a database and accessed through a structured data model, ensuring efficient data management.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>MVC pattern</h4>
            <p>Adheres to the Model-View-Controller (MVC) design pattern, separating application logic from the presentation layer for maintainability.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>Image uploads</h4>
            <p>Enables users to upload images in specified formats. Provides error messages for uploads that do not meet the specified criteria.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>Q&A feature</h4>
            <p>Features a Questions and Answers (Q&A) section with a submission form and a page displaying all questions and their corresponding answers.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>PHP, MySQL and Twig</h4>
            <p>Developed using PHP for server-side scripting, MySQL as the database management system, and Twig templating for efficient view generation.</p>
        </li>

        <li class="list-group-item bg-secondary text-white">
            <h4>OOP principles and web application security standards</h4>
            <p>Follows Object-Oriented Programming (OOP) principles and adheres to established web application security standards for robust and secure functionality.</p>
        </li>
    </ul>
</div>

<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>