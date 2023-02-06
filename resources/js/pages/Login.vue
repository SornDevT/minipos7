<template>
    <div>
        <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner d-flex justify-content-center">
      
        <div class ="col-md-4">

            <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="index.html" class="app-brand-link gap-2">
              
              <span class="app-brand-text demo text-body fw-bolder">Sneat</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">ສະບາຍດີ</h4>
          <p class="mb-4">ຍິນດີຕ້ອງຮັບ</p>

         
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌</label>
              <input type="text" class="form-control" id="email" placeholder="ປ້ນອີເມວລ໌ຂອງທ່ານ.." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ</label>
              
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">ເຂົ້າສູ່ລະບົບ</button>
            </div>

          <p class="text-center">
            <span>ບໍ່ມີບັນຊີ? </span>
            <router-link to="/register">
              <span>ລົງທະບຽນໃໝ່</span>
            </router-link>
          </p>
        </div>
      </div>

        </div>

      

 
    </div>
  </div>
    </div>
</template>

<script>
export default {
    name: 'Minipos7Login',

    data() {
        return {
            
        };
    },

    mounted() {
        
    },

    methods: {
        
    },
};
</script>

<style lang="scss" scoped>

</style>