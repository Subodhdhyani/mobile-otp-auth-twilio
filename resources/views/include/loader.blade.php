 <style>
     .loader-overlay {
         position: fixed;
         top: 45%;
         left: 45%;
         width: 100%;
         height: 100%;
         display: flex;
         justify-content: center;
         align-items: center;
         z-index: 9999;
         display: none;

     }

     .loader-container {
         display: flex;
         gap: 8px;
         align-items: flex-end;
         height: 80px;
     }

     .loader-bar {
         width: 10px;
         height: 10px;
         border-radius: 5px;
         animation: bottomUp 1.5s ease-in-out infinite alternate;
     }

     .loader-bar:nth-child(1) {
         background-color: #FF5733;
         animation-delay: 0s;
     }

     .loader-bar:nth-child(2) {
         background-color: #33FF57;
         animation-delay: 0.2s;
     }

     .loader-bar:nth-child(3) {
         background-color: #3357FF;
         animation-delay: 0.4s;
     }

     .loader-bar:nth-child(4) {
         background-color: #FF33A6;
         animation-delay: 0.6s;
     }

     .loader-bar:nth-child(5) {
         background-color: #FFD700;
         animation-delay: 0.8s;
     }

     /* Animation for up-down effect */
     @keyframes bottomUp {
         0% {
             height: 10px;
         }

         50% {
             height: 70px;
         }

         100% {
             height: 10px;
         }
     }
 </style>


 <div class="loader-overlay" id="loader">
     <div class="loader-container">
         <div class="loader-bar"></div>
         <div class="loader-bar"></div>
         <div class="loader-bar"></div>
         <div class="loader-bar"></div>
         <div class="loader-bar"></div>
     </div>
 </div>