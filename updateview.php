<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit(); 
    }
include 'connect.php'; // Include the connection file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM carm WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc(); // Fetch the record once
        $uni_dip = json_decode($record['uni_dip'], true); // Decode JSON data
        $members = json_decode($record['members'], true); // Decode JSON data

    } else {
        echo "Record not found!";
        exit();
    }
} else {
    echo "No ID specified!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="year.js" defer></script>
</head>
<body>
    <div class="tp-div">
    <h2>Update <?php echo htmlspecialchars($record['f_name']); ?>   Information</h2>
        <a href="display.php" class="back-btn">back</a>
    </div>
    <form action="update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label class="title">Personal Information / معلومات شخصية</label>
    <div class = "app-form-div" >
      <input class="app-form-div-input" type="text"  id="f_name" name="f_name" value="<?php echo htmlspecialchars($record['f_name']); ?>">
      <input class="app-form-div-input" type="text"  id="m_name" name="m_name" value="<?php echo htmlspecialchars($record['m_name']); ?>">
      <input class="app-form-div-input" type="text"  id="l_name" name="l_name" value="<?php echo htmlspecialchars($record['l_name']); ?>">
    </div>

    <div class="with-labels">
            <div class="field">
                <label class="app-form-label" for="input1">Date of Birth / تاريخ الولادة</label>
                <input class="app-form-input" type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($record['birth_date']); ?>">
            </div>
            <div class="field">
                <label class="app-form-label"  for="input2">Mobile Phone / رقم الهاتف</label>
                 <input class="app-form-input" type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($record['phone_number']); ?>" >
                
            </div>
            
            <div class="field">
                <label class="app-form-label"  for="input3">Other Phone / رقم آخر</label>
                <input class="app-form-input" type="tel" id="other_number" name="other_number" value="<?php echo htmlspecialchars($record['other_number']); ?>">
            </div> 
        </div>
        <div class="two-inputs">

        <div class="radio-group">
    <label class="radio-label" for="male">
        <input type="radio" id="male" name="gender" value="male" <?php if ($record['gender'] == 'male') echo 'checked'; ?>> Male / ذكر
    </label>
    <label class="radio-label" for="female">
        <input type="radio" id="female" name="gender" value="female" <?php if ($record['gender'] == 'female') echo 'checked'; ?>> Female / أنثى
    </label>
</div>

<div class="dropdown-group">
    <label for="nationality">Nationality / الجنسية</label>
    <select class="c" id="nationality" name="nationality">
        <option value="lebanon" <?php if ($record['nationality'] == 'lebanon') echo 'selected'; ?>>Lebanon</option>
        <option value="united states" <?php if ($record['nationality'] == 'united states') echo 'selected'; ?>>United States</option>
        <option value="france" <?php if ($record['nationality'] == 'france') echo 'selected'; ?>>France</option>
        <option value="uae" <?php if ($record['nationality'] == 'uae') echo 'selected'; ?>>UAE</option>
        <option value="germany" <?php if ($record['nationality'] == 'germany') echo 'selected'; ?>>Germany</option>
        <option value="canada" <?php if ($record['nationality'] == 'canada') echo 'selected'; ?>>Canada</option>
        <option value="uk" <?php if ($record['nationality'] == 'uk') echo 'selected'; ?>>United Kingdom</option>
    </select>
</div>
      </div>
       
    <label class="title">Current Address / عنوان الإقامة الدائمة</label>

    <div class="dropdown-field">
    <select id="residence_country" name="residence_country">
        <option value="">Select Country</option>
        <option value="lebanon" <?php if ($record['residence_country'] == 'lebanon') echo 'selected'; ?> >Lebanon</option>
        <option value="uunited state" <?php if ($record['residence_country'] == 'lebanon') echo 'selected'; ?><?php if ($record['residence_country'] == 'uunited state') echo 'selected'; ?>>United States</option>
        <option value="france" <?php if ($record['residence_country'] == 'france') echo 'selected'; ?>>France</option>
        <option value="uae" <?php if ($record['residence_country'] == 'uae') echo 'selected'; ?>>UAE</option>
    </select>

    <select id="governorate" name="governorate" style="display: none;">
        <option value="">Select City</option>
        <option value="beirut" <?php if ($record['governorate'] == 'beirut') echo 'selected'; ?>>Beirut</option>
        <option value="mlebanon" <?php if ($record['governorate'] == 'mlebanon') echo 'selected'; ?>>Mount Lebanon</option>
        <option value="bekaa" <?php if ($record['governorate'] == 'bekaa') echo 'selected'; ?>>Bekaa</option>
        <option value="nlebanon" <?php if ($record['governorate'] == 'nlebanon') echo 'selected'; ?>>North Lebanon</option>
        <option value="nabatieh" <?php if ($record['governorate'] == 'nabatieh') echo 'selected'; ?>>Nabatieh</option>
        <option value="slebanon" <?php if ($record['governorate'] == 'slebanon') echo 'selected'; ?>>South Lebanon</option>
        <option value="akkar" <?php if ($record['governorate'] == 'akkar') echo 'selected'; ?> >Akkar</option>
        <option value="baalbek" <?php if ($record['governorate'] == 'baalbek') echo 'selected'; ?>>Baalbek al hermel</option>
    </select>

    <select id="casa" name="casa" style="display: none;">
        <option value="">Select District</option>
    </select>
</div>
   <div class="address">
  <div class="address-row">
      <input class="address-row-input" style="width:100%" type="text" id="city" name="city" placeholder="city / اسم المدينة" value="<?php echo htmlspecialchars($record['city']); ?>">
      <input class="address-row-input" style="width:100%" type="text" id="street" name="street" placeholder="street / اسم الشارع"  value="<?php echo htmlspecialchars($record['street']); ?>">
      <input class="address-row-input" style="width:100%" type="text" id="building" name="building" placeholder="building / اسم المبنى" value="<?php echo htmlspecialchars($record['building']); ?>">
    </div>
    <div class="address-row">
      <input class="address-row-input" style="width:100%" type="text" id="floor" name="floor" placeholder="floor / طابق"  value="<?php echo htmlspecialchars($record['floor']); ?>">
      <input class="address-row-input" style="width:100%" type="email" id="email" name="email" placeholder="E-mail / البريد الإلكتروني"  value="<?php echo htmlspecialchars($record['email']); ?>">     
      <input class="address-row-input" style="width:100%" type="text" id="number" name="number" placeholder="+xxx xxxxxxxx" value="<?php echo htmlspecialchars($record['number']); ?>">
    </div>

    </div>


    <div class="uploads col-md-12">
    <div class="upload-field col-md-4">
        <label class="upload-label" for="file1">Upload Front ID or Passport / تحميل نسخة عن بطاقات الهوية
        </label>
        <input class="upload-input" type="file" id="file1" name="file1">
    </div>

    <div class="upload-field col-md-4">
        <label class="upload-label" for="file2">Upload Back ID or Passport / تحميل نسخة عن بطاقات الهوية</label>
        <input class="upload-input" type="file" id="file2" name="file2">
    </div>

    <div class="upload-field col-md-4">
        <label class="upload-label" for="file3">Upload Photo ID / تحميل صورة شمسية
        </label>
        <input class="upload-input" type="file" id="file3" name="file3">
    </div>
</div>
  <label class="title">Year at the school and Diplomas / سنوات الدراسة في المدرسة و الشهادات</label>
  <div class="diplome">
    <div class="diplome-drpdown">
        <label for="school">School / المدرسة</label>
        <select id="school" name="school" class="school-dropdown">
            <option value="">Select School</option>
            <option value="مدرسة مار ضومط، القبيات" <?php if ($record['school'] == 'مدرسة مار ضومط، القبيات') echo 'selected'; ?>>مدرسة مار ضومط، القبيات</option>
            <option value="مدرسة مار إلياس، طرابلس(الطليان)" <?php if ($record['school'] == 'مدرسة مار إلياس، طرابلس(الطليان)') echo 'selected'; ?>>مدرسة مار إلياس، طرابلس(الطليان)</option>
            <option value="مدرسة سيدة الكرمل، الحازمية" <?php if ($record['school'] == 'مدرسة سيدة الكرمل، الحازمية') echo 'selected'; ?>>مدرسة سيدة الكرمل، الحازمية</option>
            <option value="مدرسة الكرملية، مجدليا" <?php if ($record['school'] == 'مدرسة الكرملية، مجدليا') echo 'selected'; ?>>مدرسة الكرملية، مجدليا</option>
        </select>
    </div>
</div>

<div class="diplome-checkboxes">
    <label>Student or Staff? / طالب أم عامل؟</label>
    <div class="chkbox-container">
    <?php 
        $selected_occupations = isset($record['occupation']) ? array_map('trim', explode(',', $record['occupation'])) : []; 
    ?>
    <div>
        <input type="checkbox" id="chk1" name="occupation[]" value="student" <?php echo in_array('student', $selected_occupations) ? 'checked' : ''; ?>>
        <label for="chk1">Student / طالب</label>
    </div>
    <div>
        <input type="checkbox" id="chk2" name="occupation[]" value="staff" <?php echo in_array('staff', $selected_occupations) ? 'checked' : ''; ?>>
        <label for="chk2">Staff / عامل</label>
    </div>
    <div>
        <input type="checkbox" id="chk3" name="occupation[]" value="teacher" <?php echo in_array('teacher', $selected_occupations) ? 'checked' : ''; ?>>
        <label for="chk3">Teacher / مدرس</label>
    </div>
    <div>
        <input type="checkbox" id="chk4" name="occupation[]" value="administrative" <?php echo in_array('administrative', $selected_occupations) ? 'checked' : ''; ?>>
        <label for="chk4">Administrative / اداري</label>
    </div>
</div>
</div>
    </div>
</div>
</div>
<div class="year ">
    <div class="year-div ">
        <label class="year-div" for="year1">Year of entry / سنة الدخول</label>
        <select id="year1" name="entry_year" class="year-dropdown" data-selected="<?php echo htmlspecialchars($record['entry_year'] ?? ''); ?>">
            <option value="">year / عام</option>
        </select>
    </div>

    <div class="year-div">
        <label class="year-div" for="year2">Final Year / سنة المغادرة</label>
        <select id="year2" name="final_year" class="year-dropdown" data-selected="<?php echo htmlspecialchars($record['final_year'] ?? ''); ?>">
            <option value="">year / عام</option>
        </select>
    </div>

    <div class="year-div">
        <label class="year-div" for="year3">Graduation Year / سنة التخرج</label>
        <select id="year3" name="grad_year" class="year-dropdown" data-selected="<?php echo htmlspecialchars($record['grad_year'] ?? ''); ?>">
            <option value="">year / عام</option>
        </select>
    </div>
</div>

<label class="title">University Studies / الدراسة الجامعية</label>

<div class="uni-table">
    <table class="uni-tab">
        <thead>
            <tr>
                <th class="uni-th" colspan="2">University Studies / الدراسة الجامعية</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($uni_dip)) {
                foreach ($uni_dip as $data) {
                    echo '<tr>';
                    echo '<td class="uni-td"><input class="uni-table-input" type="text" name="university[]" value="' . htmlspecialchars($data['university']) . '" placeholder="University / الجامعة ..."></td>';
                    echo '<td class="uni-td"><input class="uni-table-input" type="text" name="diploma[]" value="' . htmlspecialchars($data['diploma']) . '" placeholder="Diploma / الشهادة ..."></td>';
                    echo '</tr>';
                    
                }
            } else {
                // Display empty rows if no data found
                for ($i = 0; $i < 4; $i++) {
                    echo '<tr>';
                    echo '<td class="uni-td"><input class="uni-table-input" type="text" name="university[]" placeholder="University / الجامعة ..."></td>';
                    echo '<td class="uni-td"><input class="uni-table-input" type="text" name="diploma[]" placeholder="Diploma / الشهادة ..."></td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>
 <label class="title">Professional information / معلومات احترافية</label>

 <div class="pro-info">
      <input class="pro-info-input" type="text" id="career" name="career" placeholder="Career / المهنة ..." value="<?php echo htmlspecialchars($record['career']); ?>">
      <input class="pro-info-input" type="text" id="position" name="position" placeholder="Position, Title / الوظيفة ..." value="<?php echo htmlspecialchars($record['position']); ?>">
      <input class="pro-info-input" type="text" id="company" name="company" placeholder="Company, Establishment / إسم الشركة ، المؤسسة ..." value="<?php echo htmlspecialchars($record['company']); ?>">
 </div>
<label class="title">Do you have any older brothers / sisters / other family members of the Carmelite Fathers Alumni?<br>
هل لديك اخوة / اخوات / او احد اعضاء العائلة من قدامى مدارس الآباء الكرمليين في لبنان؟</label>

<div class="radio-group" style="margin-left:30px">
        <label class="radio-label" for="yes">
            <input type="radio" id="yes" name="sibilings" value="yes" <?php if ($record['sibilings'] == 'yes') echo 'checked'; ?>> Yes / نعم
        </label>
        <label class="radio-label" for="no">
            <input type="radio" id="no" name="sibilings" value="no" <?php if ($record['sibilings'] == 'no') echo 'checked'; ?>> No / لا
        </label>
    </div>
    

    <div class="siblings-cont">
    <table class="siblings-table">
        <thead>
            <tr>
                <th class="table-header">Name / الإسم</th>
                <th class="table-header">E-mail / البريد الإلكتروني</th>
                <th class="table-header">Mobile Phone / رقم الهاتف</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($members)) {
                foreach ($members as $member) {
                    echo '<tr>';
                    echo '<td class="table-cell"><input class="sib-table-input" type="text" name="name[]" value="' . htmlspecialchars($member['name']) . '" placeholder="Name / الإسم ..."></td>';
                    echo '<td class="table-cell"><input class="sib-table-input" type="text" name="e_mail[]" value="' . htmlspecialchars($member['e_mail']) . '" placeholder="E-mail / البريد الإلكتروني ..."></td>';
                    echo '<td class="table-cell"><input class="sib-table-input" type="text" name="mobile_phone[]" value="' . htmlspecialchars($member['mobile_phone']) . '" placeholder="Mobile Phone / رقم الهاتف ..."></td>';
                    echo '</tr>';
                }
            } else {
                // Display empty rows if no data found
                for ($i = 0; $i < 3; $i++) {
                    echo '<tr>';
                    echo '<td class="table-cell"><input class="sib-table-input" type="text" name="name[]" placeholder="Name / الإسم ..."></td>';
                    echo '<td class="table-cell"><input class="sib-table-input" type="text" name="e_mail[]" placeholder="E-mail / البريد الإلكتروني ..."></td>';
                    echo '<td class="table-cell"><input class="sib-table-input" type="text" name="mobile_phone[]" placeholder="Mobile Phone / رقم الهاتف ..."></td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>


<label class="last">ما هي رسالتك الى مدرستك؟</label>

<div class="msg">
    <input class="input-msg" type="text" id = "message" name = "message" placeholder="Here goes your message / اكتب هنا ... " value="<?php echo htmlspecialchars($record['message']); ?>">
</div>
<div class = "up-div">
        <button type="submit" name="update" class="upd-btn" >Update</button>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Function to populate the dropdown with years from the current year to 1950
    function populateYearDropdown(dropdownId) {
        let yearDropdown = document.getElementById(dropdownId); // Get the dropdown element
        let selectedYear = yearDropdown.getAttribute("data-selected"); // Get the preselected year from the data attribute

        // Get the current year
        let currentYear = new Date().getFullYear();

        for (let year = currentYear; year >= 1950; year--) {
            let option = document.createElement("option"); 
            option.value = year; 
            option.textContent = year; 

            if (year == selectedYear) { 
                option.selected = true; 
            }

            yearDropdown.appendChild(option); 
        }
    }

    populateYearDropdown("year1"); 
    populateYearDropdown("year2"); 
    populateYearDropdown("year3"); 
});
    </script>
  

  <script>
document.getElementById("residence_country").addEventListener("change", function () {
    let country = this.value;
    let cityDropdown = document.getElementById("governorate");
    let districtDropdown = document.getElementById("casa");

    if (country === "lebanon") {
        cityDropdown.style.display = "inline-block";
    } else {
        cityDropdown.style.display = "none";
        districtDropdown.style.display = "none";
    }
});

document.getElementById("governorate").addEventListener("change", function () {
    let city = this.value;
    let districtDropdown = document.getElementById("casa");

    if (city && city !== "beirut" && city !=="akkar") {
        districtDropdown.style.display = "inline-block";
        updateDistricts(city);
    } else {
        districtDropdown.style.display = "none";
    }
});

function updateDistricts(city) {
    let districtDropdown = document.getElementById("casa");
    districtDropdown.innerHTML = ""; // Clear existing options

    let districts = {
        mlebanon: ["Aley", "baabda", "Jbeil","Keserwan","Metn","Chouf"],
        bekaa: ["Rashaya", "Bekaa West", "Zahle"],
        nlebanon: ["Batroun", "Bechare", "Al Mineh Dounieh"],
        nabatieh: ["Bint Jbeil", "Hasbaya", "Marjeyoun","Nabatieh"],
        slebanon: ["Jezzine", "Saida", "tyre"],
        baalbek: ["Baalbek", "Hermel"],
    };

    // Populate new districts
    if (districts[city]) {
        districts[city].forEach(district => {
            let option = document.createElement("option");
            option.value = district.toLowerCase();
            option.textContent = district;
            districtDropdown.appendChild(option);
        });
    }
}
</script>


</body>
</html>
