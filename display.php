    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit(); 
    }



    include 'get.php';
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Display Data</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
            <h2 class="mb-3">User Data</h2>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>First Name</th>
                        <th>middle name</th>
                        <th>Last Name</th>
                        <th>Birth Date</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>res country</th>
                        <th>governorate</th>
                        <th>casa</th>
                        <th>city</th>
                        <th>street</th>
                        <th>building</th>
                        <th>floor</th>
                        <th>email</th>
                        <th>number</th>
                        <th>occupation</th>
                        <th>Education</th>
                        <th>Front ID</th>
                        <th>Back ID</th>
                        <th>ID</th>
                        <th>school</th>
                        <th>entry year</th>
                        <th>final year</th>
                        <th>grad year</th>
                        <th>Career</th>
                        <th>Position</th>
                        <th>Company</th>
                        <th>Sibilings</th>
                        <th>Members</th>
                        <th>Message</th>
                        <th>hello   </th>


                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['f_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['m_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['l_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['birth_date']); ?></td>
                            <td><?php echo htmlspecialchars($record['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($record['gender']); ?></td>
                            <td><?php echo htmlspecialchars($record['nationality']); ?></td>
                            <td><?php echo htmlspecialchars($record['residence_country']); ?></td>
                            <td><?php echo htmlspecialchars($record['governorate']); ?></td>
                            <td><?php echo htmlspecialchars($record['casa']); ?></td>
                            <td><?php echo htmlspecialchars($record['city']); ?></td>
                            <td><?php echo htmlspecialchars($record['street']); ?></td>
                            <td><?php echo htmlspecialchars($record['building']); ?></td>
                            <td><?php echo htmlspecialchars($record['floor']); ?></td>
                            <td><?php echo htmlspecialchars($record['email']); ?></td>
                            <td><?php echo htmlspecialchars($record['number']); ?></td>
                            

                            <td>
                                    <?php if (!empty($record['occupation'])): ?>
                                         <ul>
                                     <?php foreach ($record['occupation'] as $occ): ?>
                                     <li><?php echo htmlspecialchars($occ); ?></li>
                                  <?php endforeach; ?>
                                 </ul>
                                  <?php else: ?>
                                         No Occupation
                                     <?php endif; ?>
                                    </td>


                            <td>
                                <?php if (!empty($record['uni_dip'])): ?>
                                    <ul>
                                        <?php foreach ($record['uni_dip'] as $uni): ?>
                                            <li><?php echo htmlspecialchars($uni['university'] . ' - ' . $uni['diploma']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    No education data
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($record['fid_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($record['fid_path']); ?>" alt="Front ID" width="100">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($record['bid_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($record['bid_path']); ?>" alt="Back ID" width="100">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($record['id_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($record['id_path']); ?>" alt=" ID" width="100">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($record['school']); ?></td>
                            <td><?php echo htmlspecialchars($record['entry_year']); ?></td>
                            <td><?php echo htmlspecialchars($record['final_year']); ?></td>
                            <td><?php echo htmlspecialchars($record['grad_year']); ?></td>
                            <td><?php echo htmlspecialchars($record['career']); ?></td>
                            <td><?php echo htmlspecialchars($record['position']); ?></td>
                            <td><?php echo htmlspecialchars($record['company']); ?></td>
                            <td><?php echo htmlspecialchars($record['sibilings']); ?></td>

                            <td>
                                <?php if (!empty($record['members'])): ?>
                                    <ul>
                                        <?php foreach ($record['members'] as $sib): ?>
                                            <li><?php echo htmlspecialchars($sib['name'] . ' - ' . $sib['e_mail'] . ' - ' . $sib['mobile_phone']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    No education data
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($record['message']); ?></td>

                            <td>
                            <a href="updateview.php?id=<?php echo $record['id']; ?>" class="btn btn-primary btn-sm">Update</a>
                            <a href="delete.php?id=<?php echo $record['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <div style = "display: flex; gap:20px;">
            <form action="logout.php" method="POST">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
            <a href="download_pdf.php" class="btn btn-success mb-3">Download as PDF</a>
            <a href="download_excel.php" class="btn btn-success">Download Excel</a>
        </div>
        </div>
        
        
        
        <script>
    let timeout;
    function resetLogoutTimer() {
        clearTimeout(timeout); 
        timeout = setTimeout(function() {
            window.location.href = "logout.php"; 
        }, 300000); //5 minutes
    }

    document.addEventListener("mousemove", resetLogoutTimer);
    document.addEventListener("keypress", resetLogoutTimer);

    resetLogoutTimer();
    </script>


    </body>
    </html>