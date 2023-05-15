<script setup>
import Layout from '../layout.vue'
import { Head, router} from '@inertiajs/vue3'
import { reactive } from 'vue'
import Modal from '../components/modal.vue'
import { useForm } from '@inertiajs/vue3'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/dist/sweetalert2.min.css';


const  props = defineProps({
    roles: Object,
});

const state = reactive({ showCreateModal: false, showEditModal :false })

const form = useForm({
     name:null,
     id:null
})

const fillForm=(index,input)=>{
   return  form[input]=props.roles[index][input];
}

const successMessage=(message) => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    })
}

const openModalCreate = () => {
    state.showCreateModal=true;
}


const closeModalCreate = () => {
    state.showCreateModal=false;
    form.clearErrors()
    form.reset();
}


const create = () => {
    form.post(route('dashboard.roles.store'), {
         preserveScroll: true,
         onSuccess: () => {
             closeModalCreate();
             successMessage('Role Created Successfully');
         },
    })
}


const openModalUpdate = (index) => {
    state.showEditModal=true;
    fillForm(index,'name');
    fillForm(index,'id');
}

const closeModalUpdate = () => {
    state.showEditModal=false;
    form.clearErrors()
    form.reset();
}

const update = () => {
    form.put(route('dashboard.roles.update'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModalUpdate();
            successMessage('Role Updated Successfully');
            
        },
    })
}

const destroy = (id) =>{
    router.delete(route('dashboard.roles.destroy',id));
}


const showAlert=(id) =>{
    Swal.fire({
      title: 'Are you sure?',
      text: 'You will not be able to recover this '+id,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
    }).then((result) => {
      if (result.value) {
           destroy(id);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // User clicked cancel button
      }
    })
}


</script>
<template>
    <Head :title="'Roles'"></Head>
    <Layout>
        <Modal v-if="state.showCreateModal" :title="'Create Role'">
            <template #header>
                <button class="btn-close" @click="closeModalCreate"></button>
            </template>
            <template #body>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                            <input v-model="form.name" type="text" class="form-control" id="basic-default-name" placeholder="Enter name">
                            <span v-if="form.errors.name" class="text-danger" >{{form.errors.name}}</span>
                        </div>
                    </div>
            </template>
            <template #footer>
                <button type="button" @click="closeModalCreate" class="btn btn-dark">Close</button>
                <button type="submit" @click="create" class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        Save
                </button>
            </template>
        </Modal>
        <Modal v-if="state.showEditModal" :title="'Update Role'">
            <template #header>
                <button class="btn-close" @click="closeModalUpdate"></button>
            </template>
            <template #body>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                    <div class="col-sm-10">
                        <input v-model="form.name" type="text" class="form-control" id="basic-default-name" placeholder="Enter name">
                        <span v-if="form.errors.name" class="text-danger" >{{form.errors.name}}</span>
                    </div>
                </div>
            </template>
            <template #footer>
                <button type="button" @click="closeModalUpdate" class="btn btn-dark">Close</button>
                <button type="submit" @click="update" class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Update
                </button>
            </template>
        </Modal>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <button type="button" class="btn btn-success" @click="openModalCreate">Create</button>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>guard</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(role,index) in roles">
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ role.id }}</strong></td>
                    <td>{{ role.name }}</td>
                    <td>{{ role.guard_name }} </td>
                    <td>{{ role.created_at }}</td>
                    <td >{{ role.updated_at }}</td>
                    <td>
                      <div class="row ">
                          <div class="col-6">
                             <button type="button" @click="openModalUpdate(index)" class="btn btn-warning mx-1">Edit</button>
                             <button type="button" @click="showAlert(role.id)" class="btn btn-danger mx-1">Delete</button>
                          </div>
                      </div>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
    </Layout>
</template>
<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>