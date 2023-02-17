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
                            
                        <img class="card-img-top img-cover" src="assets/img/elements/18.jpg" alt="Card image cap">
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
                        <div class=" d-flex justify-content-between fs-4 text-primary ">
                            
                                <span><strong> ລວມຍອດເງິນ:</strong></span>
                                <span><strong>{{ formatPrice(TotalAmount) }}</strong></span>
                           
                        </div>
                        
                            <button type="button" class="btn rounded-pill btn-info mt-2" :disabled="!TotalAmount" style="width:100%">ຊຳລະເງິນ</button>
                       
                        
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
        add_product(id){
            

            let item = this.StoreData.data.find((i)=>i.id == id)

            // console.log(item)

            let list_order = this.ListOrder.find((i)=>i.id==id)

            if(list_order){
                // console.log(list_order)

                // ເພີ່ມຈຳນວນຂື້ນ 1
                list_order.order_amount++

            } else {
                this.ListOrder.push({
                id: item.id,
                name:item.name,
                price_sell: item.price_sell,
                order_amount: 1
            })
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