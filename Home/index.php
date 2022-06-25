<?php include_once('./php/session.php');?>
<?php include_once('./php/PDO.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ Home</title>
    <?php include_once('./PagesTools/Head.php');?>
</head>
<body>
    <div class="container">
        <?php include_once('./PagesTools/NavBar.php');?>
        <p class="h1" style="margin-left:2%; margin-top:2rem; font-size:2rem">Home</p>
        <button style="margin-left: 60%;" id='CreateGroup' type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ModalCreateGroup">Create Group</button>
        <button style="margin-left: 10%;" id='AddGroup' type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAddGroup">Add Group</button>
 
        <div class="BoxOfGroups border border-5">
            <?php
                $Id=$_SESSION['id'];
                $Check="SELECT * from TGroups WHERE id in (SELECT GroupId FROM TUsersOfGroups WHERE (UserId='$Id') and (REQUEST='Accept'))";
                $Check=$conn->query($Check)->fetchAll();
                foreach($Check as $C){
                    print_r('<a href="./Group.php?id='.$C['id'].'"><div class="card text-dark bg-light mb-3" ><div class="card-header">Group Id: '.$C['id'].'</div><div class="card-body"><h5 class="card-title">Group Name: '. $C['GName'].'</h5><p class="card-text">'. $C['GDescription'] .'</p></div></div></a>');
                }
            ?>

        </div>
        <!-- CreateGroup Modal -->
        <div class="modal fade" id="ModalCreateGroup" tabindex="-1" aria-labelledby="ModalCreateGroupLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalCreateGroupLabel">Create Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="container-sm">
                                <div id="Alert"></div>
                                <div class="form-outline">
                                    <input type="text" id="GroupName_Create" class="form-control form-control-lg" />
                                    <label class="form-label" for="GroupName_Create">Group Name <span style='color:red;'>*</span></label>

                                </div>
                                <div class="form-group purple-border">
                                        <label for="Description">Description</label>
                                        <textarea class="form-control" id="Description_CreateGroup" rows="3"></textarea>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="isPrivate" />
                                    <label class="form-check-label" for="isPrivate">isPrivate</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="AllowUsersToSendJoinRequest" checked/>
                                    <label class="form-check-label" for="AllowUsersToSendJoinRequest">Allow Users To Send Join Request</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" id='ModalCreateGroupbtn' class="btn btn-primary" >Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- AddGroup Modal -->
        <div class="modal fade" id="ModalAddGroup" tabindex="-1" aria-labelledby="ModaladdGroupLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModaladdGroupLabel">Add Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="AlertRe"></div>
                    <nav class="navbar navbar-expand-lg bg-light">
                        
                        <div class="container-fluid">
                            
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <h1>Search For New Group By:</h1>
                                <select id='SelectSeachBy' class="form-select" aria-label="Default select example">
                                    <option value="Id">Id</option>
                                    <option value="Name">Name</option>
                                </select>
                            </div>
                            <div class="d-flex" role="search">
                                <input maxlength='50' id='InputSearch' class="form-control" type="search" placeholder="Search" aria-label="Search">
                            </div>
                        </div>
                    </nav>
                    <div class="BoxOfGroups border border-info border-5" style='height: 15rem;' id='SearchBox'>
                        <h1 id='text'></h1>
                        <ul class="list-group" id='SearchResultList'>
                        </ul>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include_once('./PagesTools/Scripts.php');?>
</body>
</html>

<?php $conn = null;?>
