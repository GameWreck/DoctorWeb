<script setup>
import Layout from '../layout.vue'
import {Link, Head, router} from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Modal from '../components/modal.vue'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/dist/sweetalert2.min.css';

const  props = defineProps({
    users:{
        type:Object,
        required:true
    },
    roles:{
        type:Object,
        required:true
    }

});

const state = reactive({ showModalAssign: false , showModelRevoke: false })

const form = useForm({
    role:'Select',   //default value select
    user:null,     
})

const successMessage=(message) => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    })
}

const openAssignModal=(id)=>{
    state.showModalAssign=true;
    form.user=id;
}

const closeAssignModal=()=>{
    state.showModalAssign=false;
    form.clearErrors();
    form.reset();
}

const assign=()=>{
    form.post(route('dashboard.appusers.asignrole'), {
        preserveScroll: true,
        onSuccess: () => {
            closeAssignModal();
            successMessage('Role Assigned Successfully');
            
        },
    })
}

const openRevokeModel=(id)=>{
    state.showModelRevoke=true;
    form.user=id;
}

const closeRevokeModal=()=>{
    state.showModelRevoke=false;
    form.clearErrors();
    form.reset();
}

const revoke=()=>{
    form.delete(route('dashboard.appusers.revokerole'), {
        preserveScroll: true,
        onSuccess: () => {
            closeRevokeModal();
            successMessage('Role Revoked Successfully');
            
        },
    })
}

const destroy=(id) =>{
    router.delete(route('dashboard.appusers.destroy',id));
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
    <Head :title="'App Users'"></Head>
    <Modal v-if="state.showModalAssign" :title="'Assign Role'">
            <template #header>
                <button class="btn-close" @click="closeAssignModal()"></button>
            </template>
            <template #body>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                            <select  v-model="form.role"  class="form-select"  aria-label="Default select example">
                                <option selected >Select</option>
                                <option v-for="(role,index) in roles" >{{ role.name }}</option>
                             </select>
                             <span class="text-danger">{{ form.errors.role }}</span>
                        </div>
                    </div>
            </template>
            <template #footer>
                <button type="button" @click="closeAssignModal()" class="btn btn-dark">Close</button>
                <button type="submit" @click="assign()" class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        Save
                </button>
            </template>
        </Modal>
        <Modal v-if="state.showModelRevoke" :title="'Revoke Role'">
            <template #header>
                <button class="btn-close" @click="closeRevokeModal()"></button>
            </template>
            <template #body>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                            <select  v-model="form.role"  class="form-select"  aria-label="Default select example">
                                <option selected >Select</option>
                                <option v-for="(role,index) in roles" >{{ role.name }}</option>
                             </select>
                             <span class="text-danger">{{ form.errors.role }}</span>
                        </div>
                    </div>
            </template>
            <template #footer>
                <button type="button" @click="closeRevokeModal()" class="btn btn-dark">Close</button>
                <button type="submit" @click="revoke()" class="btn btn-danger" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        Revoke
                </button>
            </template>
        </Modal>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
            <div class="card-header">
                <Link :href="route('dashboard.appusers.createform')" as="button" class="btn btn-success">Create</Link>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(user,index) in users" >
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ user.id }}</strong></td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }} </td>
                    <td>{{ user.created_at }} </td>
                    <td>{{ user.updated_at }} </td>
                    <td>
                      <div class="row">
                          <div class="col-6 ">
                             <Link as="button"  :href="route('dashboard.appusers.editform',user.id)" type="button" class="btn btn-warning mx-1">Edit</Link>
                             <button @click="openAssignModal(user.id)" type="button" class="btn btn-primary mx-1">Assign Role</button>
                             <button @click="openRevokeModel(user.id)"  type="button"  class="btn btn-danger mx-1">Revoke Role</button>
                             <button @click="showAlert(user.id)"  type="button"  class="btn btn-danger mx-1">Delete</button>
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