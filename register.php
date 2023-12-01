<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Membership Registration-BCC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php require 'header.php'; ?>


    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-top: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-00">Membership Registration</h1>
        </div>
    </div>
    <!-- Header End -->


    <div class="container-fluid px-0 py-5 flex justify-center">
    <div class="bg-white p-5 rounded-md">
        <h1 class="text-2xl font-bold mb-4 text-center">*Fill out infos and become member!</h1>
        <form action="insert_data.php" method="post">
            <div class="mb-4">
                <label for="std_id" class="block font-semibold">Student ID:</label>
                <input type="text" name="std_id" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="fullname" class="block font-semibold">Full Name:</label>
                <input type="text" name="fullname" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="dept" class="block font-semibold">Department:(Write it in all Caps. Ex: CSE)</label>
                <input type="text" name="dept" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="session" class="block font-semibold">Session:</label>
                <select name="session" class="w-full p-2 border border-gray-300 rounded">
                    <option value="Fall">Fall</option>
                    <option value="Spring">Spring</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="admityr" class="block font-semibold">Admission Year:</label>
                <input type="text" name="admityr" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block font-semibold">Email:</label>
                <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="c_number" class="block font-semibold">Contact Number:</label>
                <input type="text" name="c_number" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="gender" class="block font-semibold">Gender:</label>
                <select name="gender" class="w-full p-2 border border-gray-300 rounded">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Submit</button>
        </form>
    </div>
</div>


<?php require 'footer.php'; ?>