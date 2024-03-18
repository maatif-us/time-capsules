<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-2">All Capsules</h4>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-3">
                <Input @update:searchQuery="handleSearchChange"  />
              </div>
              <div class="col-6">
                <DateTimeRangePicker
                  :dateTimeRange="dateTimeRange"
                  @update:dateTimeRange="handleDateTimeChange"
                  
                />
              </div>
              <div class="col-3 text-end">
                <router-link :to="{ name: 'create' }" class="btn btn-sm btn-primary"
                  >Create</router-link
                >
              </div>
            </div>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Remaining Time</th>
                  <th>Is Opened</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="capsule in capsules" :key="capsule.id">
                  <td>{{ calculateRemainingTime(capsule.openeingTime) }}</td>
                  <td>{{ capsule.isOpened ? "Yes" : "No" }}</td>
                  <td>{{ !isTimeRemaining(capsule.openeingTime) ? capsule.message : "-"  }}</td>
                  <td>
                    <div class="btn-group">
                      <router-link :to="{ name: 'view', params: { id: capsule.id } }">
                        <el-button
                          :disabled="isTimeRemaining(capsule.openeingTime)"
                          size="small"
                          type="info"
                          >View</el-button
                        >
                      </router-link>
                      <router-link :to="{ name: 'edit', params: { id: capsule.id } }">
                        <el-button
                          :disabled="isTimeRemaining(capsule.openeingTime)"
                          size="small"
                          type="warning"
                          >Edit</el-button
                        >
                      </router-link>
                      <ConnfirmBtn
                        :title="'This action can not be reverted'"
                        :item="capsule"
                        @is:connfirmed="handleDelete"
                      />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="!capsules.length" class="text-center">
              <p>No capsules available.</p>
            </div>
            <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="pagination.currentPage"
              :page-sizes="[10, 20, 30, 50]"
              :page-size="pagination.perPage"
              :total="pagination.total"
              layout="total, sizes, prev, pager, next, jumper"
              class="mt-3"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { debounce } from "lodash";

import Input from '@/components/FormComponents/Inputs/Input.vue'
import DateTimeRangePicker from "@/components/FormComponents/DateTimePickers/DateTimeRangePicker.vue";
import ConnfirmBtn from "@/components/FormComponents/Buttons/ConnfirmBtn.vue";

export default {
  name: "capsules",
  components: {
    Input,
    DateTimeRangePicker,
    ConnfirmBtn,
  },
  data() {
    return {
      dateTimeRange: [],
    };
  },
  computed: {
    ...mapGetters("capsule", [
      "pagination",
      "capsules",
      "searchQuery",
      "isLoading",
      "startDate",
      "endDate",
    ]),
    user() {
      return this.$store.state.auth.user;
    },
  },
  created() {
    this.resethForm();
    this.fetchCapsules();
    this.dateTimeRange = [this.startDate, this.endDate];
  },
  mounted() {},
  methods: {
    ...mapActions("capsule", [
      "fetchCapsules",
      "deleteCapsule",
      "setCurrentPage",
      "setPerPage",
      "setSearchQuery",
      "setStartEndDate",
      "resethForm",
    ]),
    handleSizeChange(val) {
      this.setPerPage(val);
      this.fetchCapsules();
    },
    handleCurrentChange(val) {
      this.setCurrentPage(val);
      this.fetchCapsules();
    },
    handleDebouncedSearch: debounce(function (value) {
      this.handleSearchChange(value);
    }, 300),

    handleSearchChange(val) {
      this.setSearchQuery(val);
      this.fetchCapsules();
    },
    handleDateTimeChange(range) {
      this.setStartEndDate(range);
      this.fetchCapsules();
    },
    handleDelete(capsule) {
      try {
        this.deleteCapsule(capsule.id);
      } catch (error) {
        if (error.isAxiosError) {
          toastr.error(error.response.data.error);
        }
      }
    },
    cancelEvent() {
      console.log("cancel!");
    },

    calculateRemainingTime(openingTime) {
      const now = new Date();
      const openingDate = new Date(openingTime);
      const diff = openingDate.getTime() - now.getTime();

      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

      let timeString = "";
      if (days > 0) {
        timeString += `${days} days, `;
      }
      if (hours > 0) {
        timeString += `${hours} hours, `;
      }
      if (minutes > 0) {
        timeString += `${minutes} minutes, `;
      }
      if (timeString.endsWith(", ")) {
        timeString = timeString.slice(0, -2);
      }

      return timeString;
    },

    isTimeRemaining(openingTime) {
      const now = new Date();
      const openingDate = new Date(openingTime);
      const diff = openingDate.getTime() - now.getTime();

      if(diff > 0){
        return true;
      }
      return false;
    }
  },
};
</script>
