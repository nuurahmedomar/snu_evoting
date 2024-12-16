<!DOCTYPE html>
<html>
<head>
    <title>SNU Voting System - Registration Success</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #d2d6de;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column; /* Added flex-direction */
        }
        
        #systemHeader {
            text-align: center;
            color: #333;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .modal {
            background: #fff;
            border-radius: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
        }

        h4 {
          text-align: center;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 25px;
            margin-bottom: 20px;
        }

        .modal-title {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: black;
            text-align: center;
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }

        a:hover {
            color: red;
        }
    </style>
</head>
<body>
    <h1 id="systemHeader">SNU Voting System</h1>
    <div class="modal">
        <h4><b>Registration Successful !</b></h4>
        <div class="modal-content">
            <div class="modal-title">
                <h1>Welcome to SNU Voting System</h1>
            </div>
            <div class="modal-body">
                <p>
                    Thank you for registering <strong>SNU Voting System</strong>. Please proceed to <a href="/e-voting/admin/">Log in here</a> to access the system. <br><br>
                    #SNUVotingSystem
                </p>
            </div>
        </div>
    </div>
</body>
</html>
