<template>
    <div>
        <div class="card">
            <div class=" d-flex justify-content-between ">
                <h5 class="card-header text-primary ">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
                <div class=" me-4 pt-3 "> 
                  <!-- {{ check_butom }} -->
            
                    <button type="button" class="btn rounded-pill btn-success me-2" v-if="FormShow" :disabled="check_butom" @click="save_store()">ບັນທຶກ</button>
                    <button type="button" class="btn rounded-pill btn-danger" v-if="FormShow" @click="close()" >ຍົກເລີກ</button>
                    <button type="button" class="btn rounded-pill btn-info" @click="add_store()" v-if="!FormShow">ເພີ່ມ</button>
                </div>
            </div>
            <!-- {{ FormStore }} -->
  
  
  <div class="card-body">

    <div class="row" v-if="FormShow">
      <div class="col-md-4 text-center">
        <div style="position: relative;" >
          <button type="button" class="btn rounded-pill btn-icon btn-danger bt-rm" @click="remove_image()" v-if="image_Product" >
                 <i class='bx bx-x-circle fs-2'></i>
              </button>
        </div>
        <img :src="imagePreview" style=" width: 80%;" alt="" srcset="">
        <input type="file" class=" form-control mt-2" @change="onSelected">
      </div>
      <div class="col-md-8">
        <div class="mb-2">
          <label  class="form-label">ຊື່ສິນຄ້າ</label>
          <input type="text" class="form-control"  placeholder="..." v-model="FormStore.name" >
        </div>

        <div class="mb-2">
          <label  class="form-label">ຈຳນວນ</label>
          <cleave :options="options" class="form-control"  placeholder="..." v-model="FormStore.amount"  />
        </div>

        <div class="row">
            <div class="col-md-6">
              <label  class="form-label">ລາຄາຊື້</label>
              <cleave :options="options"  class="form-control"  placeholder="..." v-model="FormStore.price_buy"  />
            </div>
            <div class="col-md-6">
              <label  class="form-label">ລາຄາຂາຍ</label>
              <cleave :options="options"  class="form-control"  placeholder="..." v-model="FormStore.price_sell"  />
            </div>
        </div>


      </div>
    </div>

    <div v-if="!FormShow">

    
    <div class="row d-flex justify-content-end mb-2">
          <div class="col-md-3">
            <input type="text" class=" form-control" placeholder="ຄົ້ນຫາສິນຄ້າ..." v-model="search" @keyup.enter="getStore()" >
          </div>
            
      </div>

    <div class="table-responsive text-nowrap" >
      
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="40" class=" text-center">ID</th>
            <th width="120" class=" text-center">ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th width="130" class=" text-center">ລາຄາຊື້</th>
            <th width="80" class=" text-center">ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          
          
          <tr v-for="list in StoreData.data" :key="list.id">
            <td class=" text-center"> {{ list.id }} </td>
            <td> 
              <img :src="'assets/img/'+list.image" alt="" class="img-cover" v-if="list.image"> 
              <img :src="'assets/img/no-img.png'" alt="" class="img-cover" v-if="!list.image"> 
            
            </td>
            <td>
              {{ list.name }}
            </td>
            <td class=" text-end"> {{ formatPrice(list.price_buy) }} </td>
            <td class=" text-center">
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);" @click="edit_store(list.id)"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="delete_store(list.id)"><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>



        </tbody>
      </table>

      <pagination :pagination="StoreData" :offset="4" @paginate="getStore($event)" />

    </div>
  </div>
  </div>
</div>
    </div>
</template>

<script>



export default {
    name: 'Minipos7Store',

    data() {
        return {
          imagePreview: window.location.origin+'/assets/img/file-upload.png',
          image_Product:'',
            EditID:'',
            FormShow:false,
            FormType:false,
            FormStore:{
              name:'',
              amount:'',
              price_buy:'',
              price_sell:''
            },
            StoreData:[],
            options:{
              // prefix: '₭ ',
              numeral: true,
              numeralPositiveOnly: true,
              noImmediatePrefix: true,
              rawValueTrimPrefix: true,
              numeralIntegerScale: 10,
              numeralDecimalScale: 2,
              numeralDecimalMark: ',',
              delimiter: '.'
            },
            search:'',
        };
    },

    mounted() {
        
    },
    computed:{
        check_butom(){
          if(this.FormStore.name =='' && this.FormStore.amount && this.FormStore.price_buy=='' && this.FormStore.price_sell==''){
              return true
            } else {
              return false
            }
          }
    },
    methods: {
      remove_image(){
        this.imagePreview = window.location.origin+'/assets/img/file-upload.png'
        this.image_Product = ''
      },
      onSelected(envet){
          // console.log(envet.target.files[0])
          this.image_Product = envet.target.files[0]
          

          let reader = new FileReader();
          reader.readAsDataURL(this.image_Product);
          reader.addEventListener("load", function(){
            this.imagePreview = reader.result;
          }.bind(this), false);


      },
      formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".");
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      },
      showAlert() {
        // Use sweetalert2
        this.$swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href="">Why do I have this issue?</a>'
          });
      },
        add_store(){

          /// ເຄຼຍຂໍ້ມູນຟອມ ເພີ່ມສິນຄ້າໃໝ່
            this.FormStore.name = ''
            this.FormStore.amount = ''
            this.FormStore.price_buy = ''
            this.FormStore.price_sell = ''

            this.imagePreview = window.location.origin+'/assets/img/file-upload.png'
            this.image_Product = ''
          /// ເປີດຟອມ
            this.FormShow = true

        },
        close(){

            this.FormShow = false

        },
        save_store(){

            if(this.FormType){
              // ທຳການອັບເດດ

              //console.log('update')

              let formDataStore = new FormData();
              formDataStore.append("name", this.FormStore.name);
              formDataStore.append("amount", this.FormStore.amount);
              formDataStore.append("price_buy", this.FormStore.price_buy);
              formDataStore.append("price_sell", this.FormStore.price_sell);
              formDataStore.append("file", this.image_Product);
              // formDataStore.append("id", this.EditID);

              this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                  this.$axios.post(`api/store/update/${this.EditID}`, formDataStore,{headers:{"content-type":"multipart/form-data"}}).then((response)=>{

                    if(response.data.success){
                        this.$swal.fire({
                          toast:true,
                          position: 'top-end',
                          icon: 'success',
                          title: response.data.message,
                          showConfirmButton: false,
                          timer: 2500
                        })
                        } else {

                        this.$swal.fire({
                          // position: 'top-end',
                          icon: 'error',
                          title: 'ຜິດຜາດ!',
                          text: response.data.message,
                          showConfirmButton: false,
                          timer: 5500
                        })

                        }

                      this.getStore()
                      this.FormShow = false

                      // console.log(response.data)
                  }).catch((error)=>{
                    console.log(error)
                  })
              })



            } else {
              // ບັນທຶກຂໍ້ມູນໃໝ່

              let formDataStore = new FormData();
              formDataStore.append("name", this.FormStore.name);
              formDataStore.append("amount", this.FormStore.amount);
              formDataStore.append("price_buy", this.FormStore.price_buy);
              formDataStore.append("price_sell", this.FormStore.price_sell);
              formDataStore.append("file", this.image_Product);
              formDataStore.append("acc_type", "expense");

              this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                  this.$axios.post("api/store/add", formDataStore,{headers:{"content-type":"multipart/form-data"}}).then((response)=>{

                      if(response.data.success){

                        this.$swal.fire({
                          toast:true,
                          position: 'top-end',
                          icon: 'success',
                          title: response.data.message,
                          showConfirmButton: false,
                          timer: 2500
                        })
                      } else {

                        this.$swal.fire({
                          // position: 'top-end',
                          icon: 'error',
                          title: 'ຜິດຜາດ!',
                          text: response.data.message,
                          showConfirmButton: false,
                          timer: 5500
                        })

                      }
                      
                      this.getStore() /// ອັບເດດລາຍການ
                      this.FormShow = false // ປິດຟອມ
                      console.log(response.data)
                  }).catch((error)=>{
                    console.log(error)
                  })
              })

            }

            this.FormStore.name = ''
            this.FormStore.amount = ''
            this.FormStore.price_buy = ''
            this.FormStore.price_sell = ''
        },
        edit_store(id){

            // ກຳນົດຄ່າໃຫ້ທຳການອັບເດດ
            this.FormType = true

            // console.log(id)
            //ເກັບ id ໄວ້ອັບເດດຂໍ້ມູນ
              this.EditID = id
              this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.get(`api/store/edit/${id}`).then((response)=>{

                this.FormStore.name = response.data.name
                this.FormStore.amount = response.data.amount
                this.FormStore.price_buy = response.data.price_buy
                this.FormStore.price_sell = response.data.price_sell

                // ນຳຮູບພາບມາເກັບໄວ້
                this.image_Product = response.data.image
                  // ສະແດງຮູບພາບ
                if(response.data.image){
                  this.imagePreview = window.location.origin+'/assets/img/'+response.data.image
                } else {
                  this.imagePreview = window.location.origin+'/assets/img/file-upload.png'
                }

                    // console.log(response.data)
                    this.FormShow = true
                
                }).catch((error)=>{
                  console.log(error)
                })
            })

        },
        delete_store(id){
          // console.log(id)


            this.$swal.fire({
            title: 'ທ່ານແນ່ໃຈບໍ່?',
            text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ຍຶນຢັນ',
            cancelButtonText:'ຍົກເລີກ'
          }).then((result) => {
            if (result.isConfirmed) {


              this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                  this.$axios.delete(`api/store/delete/${id}`).then((response)=>{

                    if(response.data.success){
                      this.$swal.fire({
                          toast:true,
                          position: 'top-end',
                          icon: 'success',
                          title: response.data.message,
                          showConfirmButton: false,
                          timer: 2500
                        })
                    } else {
                      this.$swal.fire({
                          // position: 'top-end',
                          icon: 'error',
                          title: 'ຜິດຜາດ!',
                          text: response.data.message,
                          showConfirmButton: false,
                          timer: 5500
                        })
                    }

                    
                      this.getStore() /// ອັບເດດລາຍການ
                      // this.FormShow = false
                      // console.log(response.data)
                  }).catch((error)=>{
                    console.log(error)
                  })
              })



              
              // this.$swal.fire(
              //   'Deleted!',
              //   'Your file has been deleted.',
              //   'success'
              // )
            }
          })

          // this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
          //         this.$axios.delete(`api/store/delete/${id}`).then((response)=>{

                      
          //             this.getStore() /// ອັບເດດລາຍການ
          //             // this.FormShow = false
          //             // console.log(response.data)
          //         }).catch((error)=>{
          //           console.log(error)
          //         })
          //     })

        },
        getStore(page){

          this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.get(`api/store?page=${page}&s=${this.search}`).then((response)=>{
                this.StoreData = response.data
                // console.log(response.data)

              }).catch((error)=>{
                    console.log(error)
                    // console.log(error.response.status)
                    if(error.response.status==401){
                      this.$storage.setStorageSync("vue-isLoggin",false);
                      location.reload()
                    }
              })
          })

          

        }
        
    },
    watch:{
      'search'(){
          if(this.search == ''){
            this.getStore()
          }
      }
    },
    created(){
      this.getStore()
    }

};

</script>

<style scoped>
    .img-cover{
      width: 80px;
      height: 80px;
      object-fit: cover;
      object-position: center;
    }

    .bt-rm{
      position: absolute;right: 30px;top: 5px;
    }
</style>