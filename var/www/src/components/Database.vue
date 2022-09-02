<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
        <strong>{{this.$store.tmp.selected_database.name}}</strong> 
        </CCardHeader>
        <CCardBody>
            <CTable color="dark" responsive>
              <CTableHead>
                <CTableRow >
                <CTableHeaderCell scope="col" v-for="header in (this.$store.tmp.selected_database.description)">
                  {{header.fieldName}}
                </CTableHeaderCell>
                </CTableRow>
              </CTableHead>
              <CTableBody>
                <CTableRow active v-for="obj in this.$store.tmp.CurrentTableData">
                  <CTableDataCell v-for="field in Object.values(obj)">{{field}}</CTableDataCell>
                </CTableRow>
              </CTableBody>
            </CTable>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import $ from "jquery";
export default {
  name: 'MyTable',
  created() {
    this.getDatabase(this.$store.etc.token);
    this.$store.tmp.CurrentTableData.forEach((obj)=>{
        delete obj['_id'];
      });
  },
  methods : {
  getDatabase(token)
    {
      var send={};
      send.token=token;
      send.data="test";
      send.path="/databases/test/GET";
      send.pos=1;
      send.count=5;
      send.company=this.$store.etc.company;
      send=btoa(JSON.stringify(send));
    $.ajax({
      type: 'POST',
      data: send, 
      url: this.$store.etc.rest+"/serve",
      success:
      (response) =>
          {
            this.$store.tmp.CurrentTableData=JSON.parse(atob(response)).data;
          },
      error:
      (response) =>
            {
            },
        async:false
        });
    }


  }
}
</script>
