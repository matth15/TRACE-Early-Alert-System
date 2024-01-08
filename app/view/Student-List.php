<?php

$page_title ="Students";

require_once __DIR__ . "/partials/Main.header.php";
?>

<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="text-secondary">Manage Student</h4>
            </div>
        </div>
    </div>
</div>

<div class="modal fade viewStudent" id="view" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewStudentModal"><i class="fa-solid fa-address-card me-2"></i>View Student Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col col-12" id="viewModalAlert">
                    </div>
                    <hr>
                    <div class="col view-table">
                        <table class="table table-striped ">
                            <tr>
                                <th>Name</th>
                                <td id="name"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="email"></td>
                            </tr>
                            <tr>
                                <th>Grade & Strand</th>
                                <td id="strand"></td>
                            </tr>
                            <tr>
                                <th>Section</th>
                                <td id="section"></td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <td id="id"></td>
                            </tr>
                            <tr>
                                <th>Unique ID</th>
                                <td id="unique_id"></td>
                            </tr>
                            <tr>
                                <th><i class="fa-solid fa-calendar-days me-2"></i>Date Created</th>
                                <td id="dateCreated"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> <!-- View Student Modal -->

<?php if (Session::getUserType() === "admin") : ?>

    <div class="modal fade editStudent" id="edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Edit Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="updateForm">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col col-12" id="updateStudentModalAlert">
                            </div>
                            <hr>
                            <div class="input-group col-12 ">
                                <span class="input-group-text">Name</span>
                                <input class="form-control" type="text" name="name" id="name">
                            </div>
                            <div class="input-group col-12 my-3">
                                <span class="input-group-text">Email</i></span>
                                <input class="form-control" type="text" name="email" id="email">
                            </div>
                            <div class="input-group col-12 ">
                                <label class="input-group-text" for="student_GradeLevel">Grade</label>
                                <select class="form-select" id="grade" name="grade">
                                    <option value="11" disabled>Grade 11</option>
                                    <option value="12">Grade 12</option>
                                </select>
                            </div>
                            <div class="input-group col-12 my-3">
                                <label class="input-group-text" for="student_Strand">Strand</label>
                                <select class="form-select" name="strand" id="strand">
                                    <option value="ABM" disabled>ABM</option>
                                    <option value="GAS" disabled>GAS</option>
                                    <option value="TVL-ART & DESIGN" disabled>TVL ART & DESIGN</option>
                                    <option value="TVL-HE" disabled>TVL HE</option>
                                    <option value="HUMSS">HUMSS</option>
                                    <option value="TVL-ICT">TVL ICT</option>
                                    <option value="STEM" disabled>STEM</option>
                                </select>
                            </div>
                            <div class="input-group col-12">
                                <span class="input-group-text">Section</span>
                                <input class="form-control" type="text" name="section" id="section">
                            </div>
                            <div class="input-group col-12 my-3">
                                <label class="input-group-text" for="student_Class">Class</label>
                                <select class="form-select" name="class" id="class">
                                    <option value="">None</option>
                                    <?php
                                    // Loop to generate options from 'A' to 'Z'
                                    for ($letter = 'A'; $letter <= 'Z'; $letter++) {
                                        echo '<option value="' . $letter . '">' . $letter . '</option>';
                                        if ($letter === 'D') {
                                            break;
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- Modal Edit Student-->

    <div class="modal fade deleteStudent" id="delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="col col-12" id="deleteStudentModalAlert">
                        </div>
                        <hr>
                        <p class="text-secondary"> Enter <strong id="email"></strong> unique ID to delete student data. </p>
                        <input class="form-control" type="text" placeholder="Enter Unique ID" name="unique_id" id="unique_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- Delete Student Modal -->
<?php endif; ?>

<div id="toastContainer" class=" position-fixed f-flex bottom-0 end-0 p-3 " style="z-index: 11">

</div>
<div class="content-wrapper">
    <div class="container-fluid table-container">
        <div class="row">
            <div class="col">
                <h4>Student List</h4>
            </div>
            <hr>
            <div class="col col-12 py-1 py-sm-2 d-flex justify-content-end">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <input class="form-control" id="student_SearchBar" type="search" placeholder="Search" aria-label="Search">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col col-table shadow-sm col-12">
                <table id="studentTable">
                    <thead>
                        <tr>
                            <th class="hide">Name</th>
                            <th>TRACE Email</th>
                            <th>Grade & Strand</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="studentTb">
                       
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <div class="container-fluid ">
            <div class="row">
                <div class="col p-0 ">
                   <nav>
                    <ul class="pagination pagination-sm" id="pagination">

                    </ul>
                   </nav>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div> <!--  PAGE CONTENT  -->

<script src="<?php baseurl() ?>/public/assets/main.student.js"></script>
<?php require_once __DIR__."/partials/Main.footer.php"; ?>