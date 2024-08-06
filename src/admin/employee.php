<?php 
session_start(); 
if (empty($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

require_once("../connection.php");
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100"> 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GestONEE</title>
  <link href="../output.css" rel="stylesheet">
  <link href="../style2.css" rel="stylesheet">
  <style>
    .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
  </style>
  
  
</head>
<body class="h-full">
<div class="min-h-full">
   
    <header class="bg-white shadow-sm lg:static lg:overflow-y-visible" x-state:on="Menu open" x-state:off="Menu closed" :class="{ 'fixed inset-0 z-40 overflow-y-auto': open }" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex justify-between lg:gap-8 xl:grid xl:grid-cols-12">
          <div class="flex md:absolute md:inset-y-0 md:left-0 lg:static xl:col-span-2">
            <div class="flex flex-shrink-0 items-center">
              <a href="#">
                <h1 class="font1 block h-8 w-auto">GestONEE</h1>
                </a>
            </div>
          </div>
          <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6">
            <div class="flex items-center px-6 py-4 md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0">
              <div class="w-full">
                <label for="search" class="sr-only">Search</label>
                <div class="relative">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" x-description="Heroicon name: mini/magnifying-glass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
  <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"></path>
</svg>
                  </div>
                  <input id="search" name="search" class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 text-sm placeholder-gray-500 focus:border-blue-900 focus:text-gray-900 focus:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-900 sm:text-sm" placeholder="Search" type="search">
                </div>
              </div>
            </div>
          </div>
          <div class="hidden lg:flex lg:items-center lg:justify-end xl:col-span-4">
            <?php 
            echo "<h1 class='text-sm font-medium text-gray-900 hover:underline'>".$_SESSION['Direct']."</h1>";    
            ?>

            <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative ml-5 flex-shrink-0">
              <div>
                <img onclick='profile()'  loading="lazy" class="h-8 w-8 rounded-full" src="../../img/er1.png" alt="profile">
                   </div>
              
            </div>

            <button onclick="add()" class="ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-blue-500">Ajouter employee</button>
          </div>
        </div>
      </div>


      
    </header>
        
    <div class="flex py-5 ml-8 w-auto">
      <nav class="bg-gray-900 rounded-t-lX px-14 py-11 flex flex-col sticky top-4 text-white shadow-lg">
    <img loading="lazy" class="h-24 w-24 rounded-full" src="../../img/er1.png" alt="profile" />
    <br>
              <a href="./../admin/home.php" class=" text-gray-900 flex items-center px-3 py-2 text-sm font-medium rounded-md" aria-current="page" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-200 text-gray-900&quot;, Default: &quot;text-gray-700 hover:bg-blue-700&quot;">
                <img loading="lazy" src="../../img/home(2).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7 "></img>
                <span class="text-white">Home</span>
              </a>

              <a href="./profile.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/avatar(1).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white">Profile</span>
                </a>
            
              <a href="./responsable.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-3 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
              <img loading="lazy" src="../../img/briefcase.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Responsables</span>
              </a>
            
              <a href="./employee.php" class="bg-blue-700 text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
              <img loading="lazy" src="../../img/calendar(1).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Employées</span>
              </a>
            
          
                <a href="logout.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/exit.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white text-nowrap">logout</span>
                </a>


            
    </nav>
    <div class="ml-9 w-full">


    <?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const url = new URL(window.location);
            url.searchParams.delete("id");
            history.replaceState(null, "", url);
            document.getElementById("tab").style.display = "none";
        });
    </script>';
    $select = $pdo->prepare("SELECT * FROM employee WHERE id = ? ");
    $select->execute([$id]);
    $data = $select->fetch();
    if($data){
    echo "
        <form action='action.php' method='post'>
            <div id='edit' class='mt-6 bg-white p-6 rounded-lg shadow-lg' style='display:block;'>
                <input type='hidden' name='form_type' value='modifier'>
                <input type='hidden' name='idM' value='" . htmlspecialchars($id) . "'>
                <span class='close' onclick='closeedit()'>&times;</span>
                <h1 class='text-2xl font-bold mb-6'>Modifier Employee</h1>
                <div class='grid grid-cols-3 gap-6'>
                    <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>Nom</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='name' id='name' value='" . $data['name'] . "'>
                    </div>
                    <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>email</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='email' id='email' value='" . $data['email'] . "'>
                    </div>
                    <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>address</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='address' id='address' value='" . $data['address'] . "'>
                    </div>
                     <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>Type</label>
                        <select name='type' class='w-36 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 sm:text-sm'>";

                        if($data['type'] =='E'){
                        echo "<option value='E' selected>Employee</option>
                        <option value='R'>Responsable</option>";
                        }
                        elseif($data['type'] == 'R'){
                         echo "<option value='R' selected>Responsable</option>
                         <option value='E'>Employee</option>";
                       } 
                        echo "
                        </select>
                    </div>
                     <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>type de service</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='typeservice' id='typeservice' value='" . $data['typeservice'] . "'>
                    </div>
                    
                    <div class='mt-6'>
                        <button type='submit' class='w-full inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-700'>
                            Enregistrer
                        </button>
                    </div> 
                </div>
            </div>
        </form>";
                              }
                              else{
                                echo "no information";
                              }

}

    ?>
        <form action="action.php" method="post" id="editForm">
            <input type="hidden" name="form_type" value="id_empl">
            <input type="hidden" name="id_empl" id="id_empl">
        </form>


        <form action='action.php' method='post'>
            <div id='add' class='mt-6 bg-white p-6 rounded-lg shadow-lg' style='display:none;'>
                <input type='hidden' name='form_type' value='AddEmpl'>
                <span class='close' onclick='closeadd()'>&times;</span>
                <h1 class='text-2xl font-bold mb-6'>Ajouter Employee</h1>
                <div class='grid grid-cols-3 gap-6'>
                    <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>Nom</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='name' id='name'>
                    </div>
                    <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>email</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='email' id='email'>
                    </div>
                    <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>address</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='address' id='address' >
                    </div>
                     <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>genre</label>
                        <select name='gender' class='w-36 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 sm:text-sm'>
                        <option value='male' selected>male</option>
                        <option value='female'>female</option>
                        </select>
                    </div>
                     <div>
                        <label for='name' class='block text-sm font-medium text-gray-700'>type de service</label>
                        <input class='border mt-1 block w-full py-2 px-3' type='text' name='typeservice' id='typeservice'>
                    </div>
                    
                    <div class='mt-6'>
                        <button type='submit' class='w-full inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-700'>
                            Enregistrer
                        </button>
                    </div> 
                </div>
            </div>
        </form>
  

    <div id='tab' class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
        <?php
        $select = $pdo->prepare("SELECT id, name, email, typeservice, idservice,acces FROM employee");
        $select->execute();
        $data = $select->fetchAll();
        ?>

        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Service
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Access
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $employee): ?>
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($employee['name']); ?></p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($employee['email']); ?></p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($employee['typeservice']); ?></p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-center">
    <form action="action.php" method="POST" class="flex items-center">
        <select name="access" class="w-36 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 sm:text-sm">
           
        <?php  
        if($employee['acces']=='Non'){
          echo "<option value='Non' selected>Non</option>
            <option value='Oui'>Oui</option>";
        }
        elseif($employee['acces']=='Oui'){
          echo "<option value='Oui' selected>Oui</option>
          <option value='Non'>Non</option>";
        }
      
        ?>
        </select>
        <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
        <input type="hidden" name="form_type" value="form1">
        <button type='submit' style="margin-left:1rem;" class="px-4 py-1 bg-blue-700 text-white rounded-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" type="button">Save</button>
    </form>
</div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-center">
                        <form action="action.php" method="POST" class="flex items-center">
        <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
        <input type="hidden" name="form_type" value="Suppreme_empl">
        <button type="submit" class="px-3 py-1 text-white font-bold border-b text-sm inset-0 rounded-full" style="background-color:red;">Supprimer</button>
</form>
<button onclick="edit(<?php echo $employee['id']; ?>)" class="px-3 py-1 text-white font-bold border-b text-sm inset-0 rounded-full" style="background-color:orange; margin-left:0.5rem;">Modifier</button>


               </div>
                      </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    </div></div>
  
  <script>
     function edit(id) {
            document.getElementById("id_empl").value = id;
            document.getElementById("editForm").submit();
        }
        function closeedit() {
         
         document.getElementById('tab').style.display = 'block';
         document.getElementById('edit').style.display='none';
        
         
         
     }
     function add(){
      document.getElementById('add').style.display='block';
      document.getElementById('tab').style.display = 'none';
     }
     function closeadd(){
      document.getElementById('add').style.display='none';
      document.getElementById('tab').style.display = 'block';
     }

  </script>

  </body>