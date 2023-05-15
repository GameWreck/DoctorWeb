<script setup>
import Layout from '../layout.vue'
import { Head,Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'


const form = useForm({
     name:null,
     email:null,
     password:null,
     confirmpassword:null,
})



</script>
<template>
 <Head :title="'Create Appuser'"></Head>
<Layout>
 <div class="col-xl">
     <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
         <h5 class="mb-0">App User </h5>
         <h5 class="float-end">
            <Link :href="route('dashboard.appusers')">
            Back</Link>
         </h5>
      </div>
      <div class="card-body">
         <form @submit.prevent="form.post(route('dashboard.appusers.store'))">
            <div class="mb-3">
               <label class="form-label" for="basic-default-fullname">Full Name</label>
               <input v-model="form.name" type="text" class="form-control"  placeholder="John Doe">
               <span class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="basic-default-email">Email</label>
               <div class="input-group input-group-merge">
                  <input v-model="form.email" type="email"  class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                  <span class="input-group-text" >@example.com</span>
               </div>
               <div class="form-text">You can use letters, numbers &amp; periods</div>
               <span class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="basic-default-phone">Password</label>
               <input v-model="form.password" type="password" class="form-control phone-mask" placeholder="********">
               <span class="text-danger" v-if="form.errors.password">{{ form.errors.password }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="basic-default-phone">Confirm Password</label>
               <input v-model="form.confirmpassword" type="password"  class="form-control phone-mask" placeholder="********">
               <span class="text-danger" v-if="form.errors.confirmpassword">{{ form.errors.confirmpassword }}</span>
            </div>
            <button type="submit"  class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
               <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                  <span class="visually-hidden">Loading...</span>
               </div>
               Save
            </button>
         </form>
      </div>
   </div>
</div>
</Layout>
</template>