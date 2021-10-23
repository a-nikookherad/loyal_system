<body>
<div style="display: flex; flex-direction: column;text-align: center;">
    <div style="height: 100px;width:80%;padding: 15px;background: #0dcaf0">
        <h1>Bacancy Technology Mail Sending Tutorials</h1>
    </div>

    <div>
        <div style="height: 250px;width: 80%">
            <form action="" method="POST">
                @csrf
                <h6>Enter Name</h6>
                <input style="background:DarkGrey; width:500px; height:35px" type="text" name="name" value=""/>
                <br>
                <h6>Enter Email </h6>
                <input style="background:DarkGrey; width:500px; height:35px" type="email" name="email"
                       id="email">
                <br><br><br>
                <input class="btn btn-dark btn-block" type="submit" value="submit" name="submit">
            </form>
        </div>
    </div>
</div>
</body>
