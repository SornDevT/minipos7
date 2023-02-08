<template>
    <div>
        <div class="card">
            <div class=" d-flex justify-content-between ">
                <h5 class="card-header">ສະຕ໋ອກສິນຄ້າ</h5>
                <div class=" me-4 pt-3 ">
                    <button type="button" class="btn rounded-pill btn-success me-2" v-if="FormShow">ບັນທຶກ</button>
                    <button type="button" class="btn rounded-pill btn-danger" v-if="FormShow" @click="close()" >ຍົກເລີກ</button>
                    <button type="button" class="btn rounded-pill btn-info" @click="add_store()" v-if="!FormShow">ເພີ່ມ</button>
                </div>
            </div>
            {{ FormShow }}
  
  
  <div class="card-body">
    <div class="table-responsive text-nowrap">
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
          
          
          <tr>
            <td><i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>Bootstrap Project</strong></td>
            <td>Jerry Milton</td>
            <td>
            ກກກກ
            </td>
            <td><span class="badge bg-label-warning me-1">Pending</span></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
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
            FormShow:false
        };
    },

    mounted() {
        
    },

    methods: {

        add_store(){

            this.FormShow = true

        },
        close(){

            this.FormShow = false

        }
        
    },
};
</script>

<style lang="scss" scoped>

</style>