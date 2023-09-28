<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useRoute } from 'vue-router'
import { ref } from 'vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import { mdiAccountOutline, mdiLockOpenOutline, mdiAccount } from "@mdi/js";
import { Head } from '@inertiajs/vue3';
import Toolbar from '@/components/customizedComponents/Toolbar.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const route = useRoute()
const activeTab = ref(route.params.tab)

// tabs
const tabs = [
  {
    title: 'Compte',
    icon: mdiAccountOutline,
    tab: 'account',
  },
  {
    title: 'Securité',
    icon: mdiLockOpenOutline,
    tab: 'security',
  },
  
]

</script>

<template>
<Head title="Profile" />
<AuthenticatedLayout>
  <Toolbar
      styleToolbar="background-color: white;"
      :icon="mdiAccount"
      toolbarTitle="Profil"
    ></Toolbar>
  <div>
    <VTabs
      v-model="activeTab"
      show-arrows
    >
      <VTab
        v-for="item in tabs"
        :key="item.icon"
        :value="item.tab"
      >
        <VIcon
          size="20"
          start
          :icon="item.icon"
        />
        {{ item.title }}
      </VTab>
    </VTabs>
    <VDivider />

    <VWindow
      v-model="activeTab"
      class="mt-5 disable-tab-transition"
      :touch="false"
    >
      <!-- Account -->
      <VWindowItem value="account">
        <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail"
                        :status="status" />
      </VWindowItem>

      <!-- Security -->
      <VWindowItem value="security">
        <UpdatePasswordForm />
      </VWindowItem>

    </VWindow>
  </div>
</AuthenticatedLayout>
</template>


