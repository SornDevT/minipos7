<template>
    <div>

        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <h5 class="card-header">ສະຫຼຸບລາຍຮັບ-ລາຍຈ່າຍ</h5>
                    <div class=" d-flex justify-content-end"> 
                        <div class="btn-group me-2" role="group" aria-label="Basic example"> 
                        <!-- {{ month_type }} -->
                                    <button type="button" class="btn btn-secondary" @click="month_type='m'" ><i class='bx bx-chevron-right' v-if="month_type=='m'"></i> ເດືອນ</button>
                                    <button type="button" class="btn btn-secondary" @click="month_type='y'" ><i class='bx bx-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
                                </div>
                        <input type="date" class="form-control me-2" style="width: 150px;" v-model="dmy" >
                        <button type="button" class="btn btn-success me-4" @click="CreateReport()">ສະແດງລາຍງານ</button>
                    </div>
                    <div class="card-body">
                            <!-- <MonthlyChart/>  -->

                            <Linechart :chartData="chdata" :chartOption="choption" :update="update_chart" :key="key" v-if="show_chart" />

                    </div>
                    </div>

            </div>
            <div class="col-md-4">

                <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຮັບ</span>
                                <span>{{ formatPrice(sum_income) }} ກີບ</span>
                            </div>
                </div>
            </div>
            <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຈ່າຍ</span>
                                <span>{{ formatPrice(sum_expense) }} ກີບ</span>
                            </div>
                </div>
            </div>
            <div class="card">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ກຳໄລ</span>
                                <span>{{ formatPrice(sum_profit) }} ກີບ</span>
                            </div>
                </div>
            </div>

            </div>
        </div>

        
    </div>
</template>

<script>

import MonthlyChart from '../components/MonthlyChart.vue';
import Linechart from '../components/LineChart.vue';

export default {
    name: 'Minipos7Report',

    data() {
        return {
            month_type:'m',
            dmy:'',
            data_income:[],
            data_expense:[],
            chdata:[],
            choption:{
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    yAxes: [
                        {
                        ticks: {
                            display: true,
                            beginAtZero: false,
                            callback: function (value, index, values) {
                            return ( Number(value) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c; }) + " ກີບ" );
                            },
                        },
                        gridLines: {
                            show: true,
                        },
                        },
                    ],
                    },
                    tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                        return (
                            Number(tooltipItem.yLabel) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c; }) + " ກີບ" );
                        },
                    },
                    mode: "index",
                    intersect: false,
                    },
            },
            update_chart:null,
            key:0,
            show_chart: false
        };
    },
    components:{
        MonthlyChart,Linechart
    },
    mounted() {
        
    },
    computed:{
        sum_income(){
            return this.data_income.reduce((num,item) => num + item.price,0)
        },
        sum_expense(){
            return this.data_expense.reduce((num,item) => num + item.price,0)
        },
        sum_profit(){
            return this.sum_income-this.sum_expense
        }
    },

    methods: {
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".");
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      },
        CreateReport(){
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post(`api/report`,{
                  month_type: this.month_type,
                  dmy: this.dmy
                }).then((response)=>{
                
                this.data_income = response.data.income
                this.data_expense = response.data.expense
                this.GenGrap()

              }).catch((error)=>{
                    console.log(error)
                    // console.log(error.response.status)
                    if(error.response.status==401){
                      this.$storage.setStorageSync("vue-isLoggin",false);
                      location.reload()
                    }
              })
          })
        },
        GenGrap(){
            this.show_chart = true

        }
    },
};
</script>

<style lang="scss" scoped>

</style>