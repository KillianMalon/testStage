<style>
@media screen and (min-width: 780px){
  #slider{
    display: none;
  }
}
body{
  margin: 0;
  padding: 0;
  font-family: "Roboto", sans-serif; 
  background-color: #ececec;
}


header{  
  z-index: 1;
  position: fixed;
  background: rgb(32, 32, 32);
  padding: 24px;
  width: calc(100% - 0%);
  top: 0;
  height: 30px; 
}

.left_area h3{
  color: #fff;
  margin: 0;
  text-transform: uppercase;
  font-size: 22px;
  font-weight: 900;
}

.left_area span{
  color: #1992d3;
}

.logout_btn{
  padding: 6px;
  background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
  text-decoration: none;
  float: right;
  margin-top: -30px;
  margin-right: 40px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  color: #fff;
  transition: 0.5s;
  transition-property: background;
}
.logout_btn2{
  padding: 6px;
  background: #fff;
  text-decoration: none;
  float: right;
  margin-top: -30px;
  margin-right: 150px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  color: black;
  transition: 0.5s;
  transition-property: background;
}
.theme{
  padding: 6px;
  background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
  text-decoration: none;
  float: right;
  width: 30px;
  margin-top: -30px;
  margin-right: 180px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  color: black;
  transition: 0.5s;
  transition-property: background;
  border: none;
  cursor: pointer;
}
.fa-moon{
  color: white;
}
.fa-sun{
  color: white;
}

.theme2{
  padding: 6px;
  background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
  text-decoration: none;
  float: right;
  width: 30px;
  margin-top: -30px;
  margin-right: 240px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  color: black;
  transition: 0.5s;
  transition-property: background;
  border: none;
  cursor: pointer;
}
.logout_btn:hover{
  background: #fff;
  color: black;
}
.logout_btn2:hover{
  background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
  color: #fff;
}

.sidebar{
  z-index: 1;
  top: 0;
  background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
  margin-top: 78px;
  padding-top: 30px;
  position: fixed;
  left: 0;
  width: 250px;
  height: calc(100% - 9%);
  transition: 0.5s;
  transition-property: left;
  overflow-y: auto;
}

.profile_info{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.sidebar .profile_info .profile_image{
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 100px;
  margin-bottom: 10px;
}

.sidebar .profile_info h4{
  color: #ccc;
  margin-top: 0;
  margin-bottom: 20px;
}

.sidebar a{
  color: #fff;
  display: block;
  width: 100%;
  line-height: 60px;
  text-decoration: none;
  padding-left: 40px;
  box-sizing: border-box;
  transition: 0.5s;
  transition-property: background;
}

.sidebar a:hover{
  background: #222;
}

.sidebar i{
  padding-right: 10px;
}

label #sidebar_btn{
  z-index: 1;
  color: #fff;
  position: fixed;
  cursor: pointer;
  left: 300px;
  font-size: 20px;
  margin: 5px 0;
  transition: 0.5s;
  transition-property: color;
}

label #sidebar_btn:hover{
  color: #19B3D3;
}

#check:checked ~ .sidebar{
  left: -185px;
}

#check:checked ~ .sidebar a span{
  display: none;
}

#check:checked ~ .sidebar a{
  font-size: 20px;
  margin-left: 165px;
  width: 100%;
}

.content{
  width: (100% - 250px);
  margin-top: 60px;
  padding: 20px;
  margin-left: 250px;
  height: 100vh;
  transition: 0.5s;
}
.window{
  width: 100%;
}

.client{
  width: 100%;
}

#check:checked ~ .content{
  margin-left: 60px;
}

#check:checked ~ .sidebar .profile_info{
  display: none;
}

#check{
  display: none;
}

.mobile_nav{
  display: none;
}

.content .card p{
  background: #fff;
  padding: 15px;
  margin-bottom: 10px;
  font-size: 14px;
  opacity: 0.8;
}
/*PARTIE INSCRIPTION */
.contentInscription{
  width: (100% - 250px);
  margin-top: 60px;
  padding: 20px;
  margin-left: 250px;
  height: 88vh;
  transition: 0.5s;
}
#check:checked ~ .contentInscription{
  margin-left: 60px;
}
/* form{
  margin-top:50px;
} */
.divInfos{
  margin-left: 7.5%;
  width: 85%;
  display: flex;
  flex-direction:row;
  justify-content: center;
}
.divInfos div{
  width: 40%;
  display: flex;
  flex-direction:column;
  margin-right: 2%;
  margin-left: 2%;
}
.divInfos div div label{
  float: left;
  margin-left: -10px;
}
.divInfos div input[type="text"]{
  height: 25px;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}
.divInfos2{
  display: flex;
  flex-direction: column;
  align-items:center ;
  width: 85%;
  margin-left: 7.5%;
}
.divInfos2 div {
  width: 86%;
}
.divInfos2 div label{
  float: left;
  margin-left: 1%;
}
.divInfos2 input[type="text"]{
  height: 25px;
  border:none;
  width: 84%;
  margin-right: 2%;
  margin-left: 2%;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}
.divInfos2 input[type="mail"]{
  height: 25px;
  width: 84%;
  margin-right: 2%;
  margin-left: 2%;
  float: right;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}

.divInfos2 input[type="password"]{
  height: 25px;
  width: 84%;
  margin-right: 2%;
  margin-left: 2%;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}
.divInfos2 input[type="number"]{
  height: 25px;
  width: 84%;
  margin-right: 2%;
  margin-left: 2%;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}

.divInfos2 input[type="url"]{
  height:25px;
  width: 84%;
  margin-right: 2%;
  margin-left: 2%;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}
.divInfos2 select{
  height:30px;
  width: 84%;
  margin-right: 2%;
  margin-left: 2%;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}
.divInfos3{
  width: 84%;
  margin-left: 7.5%;
  display: flex;
  justify-content: center;
}
.divInfos3 input[type="submit"]{
  margin-right: 7%;
  background-color: #1992d3;
  color: white;
  border-radius: 5px;
  border: none;
  padding: 10px;
}
.divInfos3 input[type="submit"]:hover{
  background-color:#0B87A6;
  cursor: pointer;
}

.inscriptionH1{
  display: flex;
  justify-content: center;
}
.errorMessageInscription{
  display: flex;
  justify-content: center;
}

/* Responsive CSS */

@media screen and (max-width: 780px){
  .sidebar{
    display: none;
  }

  #sidebar_btn{
    display: none;
  }
  header{
    display: flex;
    flex-direction: row;
  }
  .right_area2{
    display: flex;
    align-items: center;
    justify-content: flex-end;
    
  }
  .left_area{
    width: 90%;
  }
  #slider{
    float: right;
    width: 35px;
  }
  .content{
    margin-left: 0;
    margin-top: 0px;
    padding: 10px 20px;
    transition: 0s;
    margin-top: 40px;
  }

  #check:checked ~ .content{
    margin-left: 0;
  }

  .mobile_nav{
    display: block;
    width: calc(100% - 0%);
  }

  .nav_bar{
    background: #222;
    width: (100% - 0px);
    margin-top: 70px;
    display: none;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
  }

  .nav_bar .mobile_profile_image{
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
  }

  .nav_bar .nav_btn{
    color: #fff;
    font-size: 22px;
    cursor: pointer;
    transition: 0.5s;
    transition-property: color;
  }

  .nav_bar .nav_btn:hover{
    color: #19B3D3;
  }

  .mobile_nav_items{
    background: #2F323A;
    display: none;
    margin-top: 78px;
  }

  .mobile_nav_items a{
    color: #fff;
    display: block;
    text-align: center;
    letter-spacing: 1px;
    line-height: 60px;
    text-decoration: none;
    box-sizing: border-box;
    transition: 0.5s;
    transition-property: background;
  }

  .mobile_nav_items a:hover{
    background: #19B3D3;
  }

  .mobile_nav_items i{
    padding-right: 10px;
  }
  .right_area1, .right_area3{
    display: none;
    }
  .active{
    display: block;
  }
  /* .logout_btn{
    display: none;
  } */
  .logout_btn2{
    display: none;
  }
  .fas{
    display: none;
  }
  .theme{
    display: none;
  }
  .theme2{
    display: none;
  }
}
@media screen and (max-width:500px ) {
  .left_area{
    width: 85%;
  }
}

<?php if($_SESSION['theme']=="sombre"):?>
    body{
      background-color: #222;
      color: white;
    }
  <?php endif; ?>
</style>