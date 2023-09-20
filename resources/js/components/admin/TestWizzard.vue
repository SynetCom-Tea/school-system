<template>
    <div id="app">
      <div>
        <h1>Customize with Props</h1>
        <Wizard
          squared-tabs
          card-background
          navigable-tabs
          scrollable-tabs
          :nextButton="nextButtonOptions"
          :backButton="backButtonOptions"
          :custom-tabs="[
            {
              title: 'Step 1',
            },
            {
              title: 'Step 2',
            },
            {
              title: 'Step 3',
            },
            {
              title: 'Step 4',
            },
          ]"
          :beforeChange="onTabBeforeChange"
          @change="onChangeCurrentTab"
          @complete:wizard="wizardCompleted"
        >
          <h5 v-if="currentTabIndex === 0">Tab 0</h5>
          <h5 v-if="currentTabIndex === 1">Tab 1</h5>
          <h5 v-if="currentTabIndex === 2">Tab 2</h5>
          <h5 v-if="currentTabIndex === 3">Tab 3</h5>
        </Wizard>
      </div>


    </div>
  </template>

  <script>
  import 'form-wizard-vue3/dist/form-wizard-vue3.css';
  import Wizard from 'form-wizard-vue3';

  export default {
    name: 'TestWizzard',
    components: {
      Wizard,
    },
    data() {
      return {
        currentTabIndex: 0,
      };
    },
    methods: {
      onChangeCurrentTab(index, oldIndex) {
        console.log('index',index);
        console.log('oldIndex', oldIndex);
        this.currentTabIndex = index;
      },
      onTabBeforeChange() {
        if (this.currentTabIndex === 0) {
          console.log('First Tab');
        }
        console.log('All Tabs');
      },
      wizardCompleted() {
        console.log('Wizard Completed');
      },
    },
    computed: {
        backButtonOptions() {
        return this.currentTabIndex>=1
          ? {
              text: 'Retour',
              icon: 'check',
              hideIcon: true, // default false but selected for sample
              hideText: false, // default false but selected for sample
              disabled: false,
            }
          : { disabled:true  };
      },
      nextButtonOptions() {
        return this.currentTabIndex>=0
          ? {
              text: 'Suivant',
              icon: 'check',
              hideIcon: true, // default false but selected for sample
              hideText: false, // default false but selected for sample
              disabled: false,
            }
          : { disabled:true  };
      },
    },
  };
  </script>

  <style>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }
  </style>
