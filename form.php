<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Business Promotion Form</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, rgb(102, 126, 234) 0%, rgb(118, 75, 162) 100%);
        margin: 0;
        padding: 0;
    }

    .form-container {
        max-width: 700px;
        background: white;
        margin: 100px auto;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
        font-size: 2rem;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group input {
      font-size: 15px;
    }

    .form-group-loc-pin input {
        width: 28.5%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ccc;
        background: #f8f9fa;
        font-size: 15px;
        margin-right: 5px;
        margin-bottom: 18px;
    }

    .form-group-loc input{
      width: 28.5%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #ccc;
      background: #f8f9fa;
      font-size: 15px;
      margin-right: 42px;
      margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 600;
    }

    input, select, textarea {
        width: 96%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ccc;
        background: #f8f9fa;
        font-size: 16px;
    }

    .promotion-options {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-top: 10px;
    }

    .checkbox-option {
        display: flex;
        align-items: center;
        padding: 2px 1px;
        font-size: 16px;
        font-weight: 450;
        color: #333;
        width: 95%;
    }

    .checkbox-option input[type="checkbox"] {
        margin-right: 12px;
        width: 18px;
        height: 18px;
        accent-color: #667eea;
    }

    .center-btn {
        text-align: center;
        margin-top: 20px;
    }

    .select-package-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 100px;
        border: none;
        border-radius: 30px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .select-package-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

  </style>
</head>
<body>
  <div class="form-container">
    <h2>Promote Your Business</h2>
    <form method="POST" action="submit.php">

      <div class="form-group">
        <label>Enter Your Business Name</label>
        <input type="text" name="business_name" placeholder="Business Name" required />
      </div>

      <div class="form-group-loc">
        <label>Where is Your Business Located?</label>
        <label for="pincode"></label>
          <input type="text" name="pincode" id="pincode" maxlength="6" required pattern="\d{6}" placeholder="Pincode" required>
          <small id="pin-message" style="color: red;"></small>
      </div>

      <div class="form-group-loc-pin">
          <input type="text" name="location_city" id="location_city" readonly placeholder="City" required>
          <input type="text" name="location_state" id="location_state" readonly placeholder="State" required>
          <input type="text" name="location_country" value="India" readonly placeholder="Country" required>
      </div>

      <div class="form-group">
        <label>Website URL (If Any)</label>
        <input type="url" name="website_url" placeholder="Website URL" />
      </div>

      <div class="form-group">
        <label>Google Business Profile Link (If Any)</label>
        <input type="url" name="google_profile" placeholder="Google Business Profile URL"/>
      </div>

      <div class="form-group">
        <label>Facebook Link (If Any)</label>
        <input type="url" name="facebook_link" placeholder="Facebook URL"/>
      </div>

      <div class="form-group">
        <label>Youtube Channel URL (If Any)</label>
        <input type="url" name="youtube_link" placeholder="Youtube URL"/>
      </div>

      <div class="form-group">
        <label>What would you like to promote?</label>
        <div class="promotion-options">
          <label class="checkbox-option"><input type="checkbox" name="promotion_type[]" value="google"> Google Business Profile</label>
          <label class="checkbox-option"><input type="checkbox" name="promotion_type[]" value="website"> Website</label>
          <label class="checkbox-option"><input type="checkbox" name="promotion_type[]" value="social"> Social Media Pages</label>
          <label class="checkbox-option"><input type="checkbox" name="promotion_type[]" value="all"> All</label>
        </div>
      </div>

      <div class="center-btn">
        <button type="submit" class="select-package-btn">Select Package</button>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const allCheckbox = document.querySelector('input[value="all"]');
        const otherCheckboxes = document.querySelectorAll(
        'input[name="promotion_type[]"]:not([value="all"])'
        );

        allCheckbox.addEventListener("change", function () {
        if (this.checked) {
            otherCheckboxes.forEach(cb => cb.checked = false);
        }
        });

        otherCheckboxes.forEach(cb => {
        cb.addEventListener("change", function () {
            if (this.checked) {
            allCheckbox.checked = false;
            }
        });
        });
    });

    document.getElementById("pincode").addEventListener("input", function () {
        const pincode = this.value.trim();
        const message = document.getElementById("pin-message");

        if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
            fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                .then(response => response.json())
                .then(data => {
                    const postOffice = data[0]?.PostOffice?.[0];
                    if (postOffice) {
                        document.getElementById("location_city").value = postOffice.District;
                        document.getElementById("location_state").value = postOffice.State;
                        message.textContent = "✔ Valid pincode";
                        message.style.color = "green";
                    } else {
                        document.getElementById("location_city").value = '';
                        document.getElementById("location_state").value = '';
                        message.textContent = "✖ Invalid pincode. Please check.";
                        message.style.color = "red";
                    }
                })
                .catch(() => {
                    document.getElementById("location_city").value = '';
                    document.getElementById("location_state").value = '';
                    message.textContent = "✖ Unable to fetch location.";
                    message.style.color = "red";
                });
        } else {
            document.getElementById("location_city").value = '';
            document.getElementById("location_state").value = '';
            message.textContent = "Enter a valid 6-digit pincode";
            message.style.color = "orange";
        }
    });
  </script>
</body>
</html>