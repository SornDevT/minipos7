<template>
    <div>
        <div class="card">
            <div class=" d-flex justify-content-between ">
                <h5 class="card-header">ສະຕ໋ອກສິນຄ້າ</h5>
                <div class=" me-4 pt-3 "> 
                  <!-- {{ check_butom }} -->
                    <button type="button" class="btn rounded-pill btn-success me-2" v-if="FormShow" :disabled="check_butom" @click="save_store()">ບັນທຶກ</button>
                    <button type="button" class="btn rounded-pill btn-danger" v-if="FormShow" @click="close()" >ຍົກເລີກ</button>
                    <button type="button" class="btn rounded-pill btn-info" @click="add_store()" v-if="!FormShow">ເພີ່ມ</button>
                </div>
            </div>
            {{ FormStore }}
  
  
  <div class="card-body">

    <div class="row" v-if="FormShow">
      <div class="col-md-4">1111</div>
      <div class="col-md-8">
        <div class="mb-2">
          <label  class="form-label">ຊື່ສິນຄ້າ</label>
          <input type="text" class="form-control"  placeholder="..." v-model="FormStore.name" >
        </div>

        <div class="mb-2">
          <label  class="form-label">ຈຳນວນ</label>
          <input type="text" class="form-control"  placeholder="..." v-model="FormStore.amount"  >
        </div>

        <div class="row">
            <div class="col-md-6">
              <label  class="form-label">ລາຄາຊື້</label>
              <input type="text" class="form-control"  placeholder="..." v-model="FormStore.price_buy"  >
            </div>
            <div class="col-md-6">
              <label  class="form-label">ລາຄາຂາຍ</label>
              <input type="text" class="form-control"  placeholder="..." v-model="FormStore.price_sell"  >
            </div>
        </div>


      </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!FormShow">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          
          
          <tr v-for="list in StoreData" :key="list.id">
            <td> {{ list.id }} </td>
            <td></td>
            <td>
              {{ list.name }}
            </td>
            <td> {{ list.price_buy }} </td>
            <td>
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

        add_store(){

            this.FormShow = true

        },
        close(){

            this.FormShow = false

        },
        save_store(){

            if(this.FormType){
              // ທຳການອັບເດດ

            } else {
              // ບັນທຶກຂໍ້ມູນໃໝ່

              let formDataStore = new FormData();
              formDataStore.append("name", this.FormStore.name);
              formDataStore.append("amount", this.FormStore.amount);
              formDataStore.append("price_buy", this.FormStore.price_buy);
              formDataStore.append("price_sell", this.FormStore.price_sell);

              this.$axios.post("api/store/add", formDataStore).then((response)=>{
                  this.getStore()
                  this.FormShow = false
                  console.log(response.data)
              }).catch((error)=>{
                console.log(error)
              })

            }

            this.FormStore.name = ''
            this.FormStore.amount = ''
            this.FormStore.price_buy = ''
            this.FormStore.price_sell = ''
        },
        edit_store(id){
            // console.log(id)
            //ເກັບ id ໄວ້ອັບເດດຂໍ້ມູນ
              this.EditID = id
              this.$axios.get(`api/store/edit/${id}`).then((response)=>{

              this.FormStore.name = response.data.name
              this.FormStore.amount = response.data.amount
              this.FormStore.price_buy = response.data.price_buy
              this.FormStore.price_sell = response.data.price_sell

                  console.log(response.data)
                  this.FormShow = true
              
              }).catch((error)=>{
                console.log(error)
              })

        },
        delete_store(id){
          console.log(id)
        },
        getStore(){

          this.$axios.get("api/store").then((response)=>{
            this.StoreData = response.data
            // console.log(response.data)

          }).catch((error)=>{
                console.log(error)
              })

        }
        
    },
    created(){
      this.getStore()
    }

};

</script>

<style lang="scss" scoped>

</style>