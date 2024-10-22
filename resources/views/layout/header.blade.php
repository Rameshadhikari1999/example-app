<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>First Task</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            text-transform: capitalize;
            font-size: 25px;
            color: brown;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
            margin: 0px auto;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: brown;
            color: white;
        }

        a {
            text-decoration: none;
            color: rgb(21, 169, 139);
            text-transform: capitalize;
            font-size: 22px;
            font-weight: 500;
            cursor: pointer;
            margin-left: 10px;
            color: white;
            border-radius: 5px;
            padding: 3px 10px;
            transition: all 0.3s ease;
        }

        .edit {
            background: rgb(21, 169, 139);
        }

        .delete {
            background: red;
        }

        .btn-container {
            width: 90%;
            margin: 10px auto;
            display: flex;
            justify-content: flex-end
        }

        .btn {
            text-align: center;
            margin-top: 20px;
            border: none;
            outline: none;
            background: blue;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: rgb(21, 169, 139);
        }
    </style>
</head>
<body>

