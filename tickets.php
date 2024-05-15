<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="icon" href="./assets/images/favicon.jpg">
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/tickets.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@700&display=swap">
    <title>Skyline - Profile</title>
</head>
<body>
<header>
    <div class="logo">
        <img src="./assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Profile</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="./index.php">Dashboard</a></li>
            <li><a href="./flights.php">Flights</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./Purchase.php">Purchase History</a></li>
        </ul>
    </nav>
</header>
 
  <body>
    <div class="ticketform">
      <div class="ticket-container-parent">
        <div class="ticket-container"></div>
        <img
          class="ticket-container-imgbg-icon"
          alt=""
          src="./public/ticket-container-imgbg@2x.png"
        />

        <div class="ticket-container1">
          <img
            class="ticket-icon"
            loading="lazy"
            alt=""
            src="./public/ticket-icon@2x.png"
          />

          <div class="airline-ticket-wrapper">
            <h2 class="airline-ticket">Airline Ticket</h2>
          </div>
          <div class="input-field-wrapper">
            <div class="input-field"></div>
          </div>
        </div>
        <div class="frame-wrapper">
          <div class="frame-parent">
            <div class="name-parent">
              <b class="name">Name:</b>
              <div class="date-input-field">
                <input type="text" value="" class="input-field1" style="width: 100%;" readonly ></input>
              </div>
            </div>
            <div class="departure-input-field-wrapper">
              <div class="departure-input-field">
                <div class="arrival-input-field">
                  <img
                    class="departure-icon"
                    loading="lazy"
                    alt=""
                    src="./public/departure-icon@2x.png"
                  />

                  <input type="text" value="" class="input-field2" readonly></input>
                </div>
                <div class="arrival-input-field1" >
                  <img
                    class="arrival-icon"
                    loading="lazy"
                    alt=""
                    src="./public/arrival-icon@2x.png"
                  />

                  <input type="text" value="" class="input-field3" readonly></input>
                </div>
                <div class="arrival-input-field2" style="width: 76%;">
                  <img
                    class="date-icon"
                    loading="lazy"
                    alt=""
                    src="./public/date-icon@2x.png"
                  />

                  <input type="date" value="" class="input-field4" readonly></input>
                </div>
                <div class="arrival-input-field3" style="width: 70%;">
                  <img
                    class="time-icon"
                    loading="lazy"
                    alt=""
                    src="./public/time-icon@2x.png"
                  />

                  <input type="time" value="" class="input-field5" readonly></input>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="frame-container">
          <div class="frame-group">
            <div class="class-parent">
              <b class="class">Class:</b>
              <input type="text" value="" class="input-field6" readonly ></input>
            </div>
            <div class="seat-parent">
              <b class="seat">Seat:</b>
              <input type="text" value="" class="input-field7" readonly></input>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
