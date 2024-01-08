<?php
$page_title = "Faculty";
require_once(__DIR__ . "/partials/Main.header.php") ?>
<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="text-secondary">Facultys</h4>
            </div>
        </div>
    </div>
</div>
<!-- modals -->
<div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Edit Faculty Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-12" id="editFacultyAlert">
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- Modal Edit Student-->

<div class="modal fade viewFaculty" id="view" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-address-card me-2"></i>View Faculty Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col col-12" id="viewFacultyAlert">

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
                                <th>Classroom ID</th>
                                <td id="classroomID"></td>
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
</div> <!-- View Faculty Modal -->

<div class="modal fade deleteFaculty" id="delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Delete Faculty Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" >
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <p class="text-secondary"> Enter <strong id="email"></strong> unique ID to delete student data. </p>
                    <input class="form-control" type="text" placeholder="Unique ID" name="uniqueId" id="uniqueId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- Delete Faculty Modal -->

<div id="toastContainer" class=" position-fixed f-flex bottom-0 end-0 p-3 " style="z-index: 11">

</div>

<div class="content-wrapper">
    <div class="container-fluid table-container">
        <div class="row">
            <div class="col">
                <h4>Faculty List</h4>
            </div>
            <hr>
            <div class="col col-12 py-1 py-sm-2 d-flex justify-content-end">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <input class="form-control" id="faculty_SearchBar" type="search" placeholder="Search" aria-label="Search">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-table shadow-sm col-12 ">
                <table id="facultyTable" class="table-striped">
                    <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Name</th>
                        <th>Trace Email</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="facultyTb">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col p-0">
                    <nav>
                        <ul class="pagination pagination-sm" id="pagination">
                           
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
</div> <!--  PAGE CONTENT  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="<?php baseurl() ?>/public/assets/main.faculty.js"></script>

<?php require_once(__DIR__ . "/partials/Main.footer.php") ?>