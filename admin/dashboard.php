<style>
.body {
    margin: 0;
  padding: 0;
  width: 100%;
}

.page-home {
  display: flex;
  margin-top: 50px;
  justify-content: center;
  align-items: top;
  width: 100%;
  padding: 0 15px;
}

.container-home {
  padding: 20px;
}

.container-home .row {
  display: flex;
  align-items: center; /* Vertically aligns content */
  justify-content: space-between; /* Pushes content to opposite ends */
}

.card-waves {
    max-width: 500px;
    
    margin: 0 auto;
  }

  .card {
    min-width: 80%;
  }

.card.card-waves {
  width: 80%;
  margin: 0 auto;
  margin-bottom: 5px;
  height: auto;
  background-color: #1fcda2;
  border-radius: 20px;
}

.card-body {
  color: black;
}

.card.card-waves .card-body {
  padding: 2rem;
}

.image-content img {
  max-width: 100%; /* Ensure image is responsive */
  height: auto; /* Maintain aspect ratio */
  max-height: 150px; /* Optional: Set a max height for the image */
}



.searchcontainer {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100px;
  margin-top: -30px;
  margin-bottom: 1px;
}

.search-container {
  padding: 40px;
  text-align: center;
  background-color: #fff;
  border-bottom: 1px solid #ddd;
}

.search-container h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

.search-container input[type="text"] {
  width: 60%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 5px;
}

.search-container button {
  padding: 10px 20px;
  font-size: 16px;
  color: #fff;
  background-color: #92E0CC;
  border: none;
  border-radius: 5px;
}

.search {
  border-radius: 5px;
}

::placeholder {
  color: grey;
  opacity: 1;
}

.search-2 {
  position: relative;
  display: flex;
  align-items: center;
  width: 60rem;
}

.search-2 input {
  height: 50px;
  border: none;
  flex: 1;
  padding-left: 18px;
  padding-right: 0;
  border-radius: 8px;
}

.search-2 button {
  border: none;
  height: 40px;
  background-color: #92E0CC;
  color: #fff;
  width: 90px;
  border-radius: 8px;
  margin-left: -100px;
  cursor: pointer;
}


.search-2 button:hover {
  background-color: #92E0CC;
}

</style>

<div class="body">
    
<div class="container-home">
    <div class="card card-waves mb-4 mt-5 card-red" >
      <div class="card-body p-3">
        <div class="row align-items-center justify-content-between">
          <div class="col">
            <h1 style="font-size: 30px;"><b>Selamat Datang, Admin!</b></h1>
          </div>
          <div class="col-auto d-none d-lg-block mt-xxl-n4">
            <img style="width: 100px; height: 100px;" src="../assets/foto/home.jpg">
          </div>
        </div>
      </div>
    </div>

    <div class="page-home">
      <div class="content">
        <div class="searchcontainer">
          <div class="search">
            <div class="row">
              <div class="col-md-6">
                <div class="search-2">
                  <input type="text" id="search-input" placeholder="Search">
                  <button>Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>