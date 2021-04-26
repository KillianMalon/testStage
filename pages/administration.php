td a{
        color: white;
        text-decoration: none;
        padding: 4px;
        border-radius: 5px;
        background-color: #19B3D3;
    }
    .adminAffichage td a:hover{
        background-color: #ffffff;
        color: #19B3D3;
    }
</style>

<div class="content">
   <div class="globalAdmin">
        <div class="adminAffichage">
            <h2>Administration Clients <i class="fas fa-user"></i> <a href="" class="viewAll"> Tout voir <i class="fas fa-arrow-right"></i></a></h2>
            <div>

               <table>
                   <thead>
                       <tr>
                           <th>Nom</th>
                           <th>mail</th>
                           <th>Type</th>
                           <th>Modifier</th>
                       </tr>
                   </thead>
                   <tbody>
                   <?php
                        $clients = getLastUsers($dbh);
                        foreach($clients as $client){
                            $id = $client['id'];
                            $lname = $client['nom'];
                            $mail = $client['mail'];
                            $type = $client['type'];
                   ?>
                        <tr>
                            <td><?php echo isset($lname)? $lname :" " ?></td>
                            <td> <?php echo isset($mail)? $mail : " " ?> </td>
                            <td> <?php echo isset($type)? $type : " " ?> </td>
                            <td> <a href="modifClient.php?client=<?php echo $id ?>">modifier</a> </td>
                        </tr>

                   <?php } ?>
                   </tbody>

               </table>
            </div>
        </div>
        <div class="adminAffichage">Administration Commentaires </div>
        <div class="adminAffichage">Administration Reservations </div>
   </div>
</div>