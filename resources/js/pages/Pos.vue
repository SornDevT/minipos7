<template>
    <div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <input type="text" class=" form-control" placeholder="ຄົ້ນຫາສິນຄ້າ...." v-model="search" @keyup.enter="getStore()">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3 " v-for="list in StoreData.data" :key="list.index">
                        <div class="card mb-3 cursor" @click="add_product(list.id)">
                            <span v-for="i in ListOrder" :key="i.index">
                               <div class="num-img" v-if="list.id == i.id">{{i.order_amount}}</div>
                            </span>
                            
                        <!-- <img class="card-img-top img-cover" src="assets/img/elements/18.jpg" alt="Card image cap">
                        <img class="card-img-top img-cover" src="assets/img/elements/18.jpg" alt="Card image cap"> -->

                        <img :src="'assets/img/'+list.image" alt="" class="card-img-top img-cover" v-if="list.image"> 
                        <img :src="'assets/img/no-img.png'" alt="" class="card-img-top img-cover" v-if="!list.image"> 

                        <div class="card-body p-1 text-center">
                            <strong>{{list.name}}</strong>
                            <p class="card-text">
                            {{formatPrice(list.price_sell)}}
                            </p>
                       
                        </div>
                        </div>
                    </div>
                    
                   
                </div>
            </div>
            <div class="col-md-4"> 
                <div class="card" style="height: 80vh; overflow: auto;">
                    <div class="card-body p-3">
                        <div class="row">
                                <div class="col-md-12">
                                    <label for="">ຊື່ລູກຄ້າ</label>
                                    <input type="text" class=" form-control" v-model="customer_name">
                                </div>
                                <div class="col-md-12">
                                    <label for="">ເບີໂທ</label>
                                    <input type="text" class=" form-control" v-model="customer_tel">
                                </div>
                        </div>
                        <hr>
                        <div class=" d-flex justify-content-between fs-4 text-primary ">
                            
                                <span><strong> ລວມຍອດເງິນ:</strong></span>
                                <span><strong>{{ formatPrice(TotalAmount) }} ກີບ</strong></span>
                           
                        </div>
                        
                            <button type="button" class="btn rounded-pill btn-info mt-2" :disabled="!TotalAmount" style="width:100%" @click="Confirm_to_pay()">ຊຳລະເງິນ</button>
                       
                        
                                <div class="table-responsive text-nowrap mt-4 border">
                                <table class="table">
                                <thead class="table-light">
                                    <tr>
                                    <th>ລາຍການ</th>
                                    <th>ລາຄາ</th>
                                    <th>ລວມຍອດ</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr v-for="list in ListOrder" :key="list.imdex">
                                        <td>{{ list.name }}</td>
                                        <td class="text-end">{{ formatPrice(list.price_sell) }}<br>
                                            <i class='bx bxs-minus-circle text-warning cursor' @click="remov_product(list.id)"></i> {{ list.order_amount }} <i class='bx bxs-plus-circle text-info cursor' @click="add_product(list.id)"></i> | <i class='bx bxs-x-circle text-danger cursor' @click="remove_product_one(list.id)"></i>
                                        </td>
                                        <td class="text-end">{{ formatPrice(list.price_sell*list.order_amount) }}</td>
                                    </tr>
                                 
                                </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirm_to_pay" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">ຊຳລະສິນຄ້າ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6 text-start">
                        ລວມຍອດເງິນ:
                    </div>
                    <div class="col-md-6 text-end">
                        {{ formatPrice(TotalAmount) }} ກີບ
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 text-start">
                        ຮັບເງິນນຳລູກຄ້າ:
                    </div>
                    <div class="col-md-6 text-end">
                     {{formatPrice(CashAmount)}} ກີບ
                    </div>
                  </div>
                  <div class="row text-danger" v-if="CashAmount-TotalAmount>0">
                    <div class="col-md-6 text-start">
                        ເງິນທອນ:
                    </div>
                    <div class="col-md-6 text-end">
                     {{formatPrice(CashAmount-TotalAmount)}} ກີບ
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                        <div class="col-md-5">
                            <input type="number" class=" form-control" style="text-align: right;" v-model="CashAmount">
                        </div>
                  </div>
                  <div class="d-flex justify-content-center">
                  <div class="row" style="width: 250px;">
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(1)" >1</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(2)" >2</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(3)">3</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(4)">4</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(5)">5</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(6)">6</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(7)">7</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(8)">8</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(9)">9</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum('00')">00</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(0)">0</button>
                        </div>
                        <div class="col-4 mt-2" style="width: 60px;">
                            <button type="button" style="width: 60px;" class="btn btn-danger" @click="AddNum('-')"><i class='bx bx-arrow-back'></i></button>
                        </div>
                  </div>
                </div>
                <div class="text-center mt-4">
                    <button type="button" class="btn rounded-pill btn-success" :disabled="!(CashAmount>=TotalAmount)" @click="Pay()">ຍືນຍັນຊຳລະເງິນ</button>
                </div>
              
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
    
                </div>
              </div>
            </div>
          </div>
    </div>
</template>

<script>
export default {
    name: 'Minipos7Pos',

    data() {
        return {
            StoreData:[],
            search:'',
            ListOrder:[],
            CashAmount:'',
            customer_name:'',
            customer_tel:''
        };
    },

    mounted() {
        
    },
    computed:{
        TotalAmount(){
            return this.ListOrder.reduce((num,item)=> num + item.price_sell*item.order_amount,0)
        }
    },

    methods: {
        AddNum(num){
            if(num == '-'){
                this.CashAmount = this.CashAmount.slice(0,-1)
            } else {
                this.CashAmount = this.CashAmount + num
            }
        },
        Pay(){

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                  this.$axios.post(`api/transection/add`,{
                    acc_type:'income',
                    listorder: this.ListOrder,
                    customer_name: this.customer_name,
                    customer_tel: this.customer_tel
                  }).then((response)=>{

                    if(response.data.success){

                        this.customer_name = ''
                        this.customer_tel =''
                        $('#confirm_to_pay').modal('hide')
                        this.ListOrder = []
                        this.getStore()

                        window.open(window.location.origin+'/api/bills/print/'+response.data.bills_id, "_blank")


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

                      // console.log(response.data)
                  }).catch((error)=>{
                    console.log(error)
                  })
              })
        },
        Confirm_to_pay(){

            $('#confirm_to_pay').modal('show')
        },
        add_product(id){
            

            let item = this.StoreData.data.find((i)=>i.id == id)

            // console.log(item)
            // ກວດຈຳນວນສິນຄ້າໃນສະຕ໋ອກ
            if(item.amount>0){

                    let list_order = this.ListOrder.find((i)=>i.id==id)

                    if(list_order){
                        // console.log(list_order)

                        let old_order = list_order.order_amount

                        if(item.amount - old_order>0){
                            // ເພີ່ມຈຳນວນຂື້ນ 1
                            list_order.order_amount++
                        } else {
                            this.$swal('ສິນຄ້ານີ້','ໝົດແລ້ວ','error')
                        }

                        

                    } else {
                        this.ListOrder.push({
                        id: item.id,
                        name:item.name,
                        price_sell: item.price_sell,
                        order_amount: 1
                    })
                    }
                } else {
                    this.$swal('ສິນຄ້ານີ້','ໝົດແລ້ວ','error')
                }
        },
        remov_product(id){

            let list_order = this.ListOrder.find((i)=>i.id==id)
            if(list_order){
                list_order.order_amount--
                if(list_order.order_amount<1){
                    this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
                }
            }
        },
        remove_product_one(id){
            this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
        },
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".");
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
.cursor{
    cursor: pointer;
}
.img-cover{
        height: 110px;
    width: 100%;
    object-fit: cover;
    object-position: center;
    }
    .num-img{
        position: absolute;
    right: 0px;
    top: 0px;
    background-color: darkorchid;
    color: white;
    border-radius: 0px 10px 0px 10px;
    padding: 4px;
    }
</style>