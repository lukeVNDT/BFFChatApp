<template>
  <div class="SideChat">
    <!-- BEGIN: Top Bar -->
    <div class="top-bar">
      <!-- BEGIN: Breadcrumb -->
      <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a>BFFChat</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a class="breadcrumb--active">Chat</a>
      </div>
      <!-- END: Breadcrumb -->

      <!-- BEGIN: Account Menu -->
      <div class="intro-x dropdown w-8 h-8">
        <div
          class="
            dropdown-toggle
            w-8
            h-8
            rounded-full
            overflow-hidden
            shadow-lg
            image-fit
            zoom-in
          "
          role="button"
          aria-expanded="false"
        >
          <img
            v-if="currentuser.avatar != null"
            alt="Midone Tailwind HTML Admin Template"
            class="rounded-full"
            :src="
              'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
              currentuser.avatar
            "
          />
          <img
            v-else
            alt="Avatar"
            class="rounded-full"
            :src="'../dist2/images/avatardefault_92824-removebg.png'"
          />
        </div>
        <div class="dropdown-menu w-56">
          <div
            class="
              dropdown-menu__content
              box
              bg-theme-26
              dark:bg-dark-6
              text-white
            "
          >
            <div class="p-4 border-b border-theme-27 dark:border-dark-3">
              <div class="font-medium">{{ currentuser.displayName }}</div>
            </div>
            <div class="p-2">
              <router-link
                to="/profile"
                class="
                  flex
                  items-center
                  block
                  p-2
                  transition
                  duration-300
                  ease-in-out
                  hover:bg-theme-1
                  dark:hover:bg-dark-3
                  rounded-md
                "
              >
                <i class="fas fa-user mr-2"></i>Update Profile
              </router-link>
            </div>
            <div class="p-2 border-t border-theme-27 dark:border-dark-3">
              <a
                @click="logout"
                class="
                  flex
                  items-center
                  block
                  p-2
                  transition
                  duration-300
                  ease-in-out
                  hover:bg-theme-1
                  dark:hover:bg-dark-3
                  rounded-md
                "
              >
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- END: Account Menu -->
    </div>
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
      <h2 class="text-lg font-medium mr-auto">Chat</h2>
    </div>
    <div class="intro-y chat grid grid-cols-12 gap-5 mt-5">
      <!-- BEGIN: Chat Side Menu -->
      <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
        <div class="intro-y pr-1">
          <div class="box p-2">
            <div class="chat__tabs nav nav-tabs justify-center" role="tablist">
              <a
                id="chats-tab"
                data-toggle="tab"
                data-target="#chats"
                href="javascript:;"
                class="flex-1 py-2 rounded-md text-center active"
                role="tab"
                aria-controls="chats"
                aria-selected="true"
                ><i class="fas fa-comment-dots mr-1"></i>Chats</a
              >
              <a
                id="friends-tab"
                data-toggle="tab"
                data-target="#friends"
                href="javascript:;"
                class="flex-1 py-2 rounded-md text-center"
                role="tab"
                aria-controls="friends"
                aria-selected="false"
                ><i class="fas fa-user-friends mr-1"></i>Friends</a
              >
              <a
                id="profile-tab"
                data-toggle="tab"
                data-target="#profile"
                href="javascript:;"
                class="flex-1 py-2 rounded-md text-center"
                role="tab"
                aria-controls="profile"
                aria-selected="false"
                ><i class="fas fa-bell mr-1"></i>Notification</a
              >
              <button class="btn btn-sm btn-rounded-danger friendNotyf">
                {{ notify.length }}
              </button>
            </div>
          </div>
        </div>
        <div class="tab-content">
          <div
            id="chats"
            class="tab-pane active"
            role="tabpanel"
            aria-labelledby="chats-tab"
          >
            <div class="pr-1">
              <div class="box px-5 pt-5 pb-5 lg:pb-0 mt-5">
                <div class="relative text-gray-700 dark:text-gray-300">
                  <input
                    v-model="keywords"
                    type="text"
                    class="
                      form-control
                      py-3
                      px-4
                      border-transparent
                      bg-gray-200
                      pr-10
                      placeholder-theme-13
                    "
                    placeholder="Search for users..."
                  />
                  <i
                    class="
                      w-4
                      h-4
                      hidden
                      sm:absolute
                      my-auto
                      inset-y-0
                      mr-3
                      right-0
                    "
                    data-feather="search"
                  ></i>
                </div>
                <div class="overflow-x-auto scrollbar-hidden">
                  <div class="flex mt-5"></div>
                </div>
              </div>
            </div>

            <div class="parent__loop">
              <!-- <div
                class="
                  chat__chat-list
                  overflow-y-auto
                  scrollbar-hidden
                  pr-1
                  pt-1
                  mt-4
                "
              > -->
              <div v-if="users != ''">
                <div
                  v-for="person in sortUnreadContact"
                  :key="person.id"
                  class="chatloop"
                  @click="activeuser = person"
                >
                  <div
                    v-if="currentuser.id != person.user_id"
                    :class="activeuser.id == person.user_id ? 'active' : ''"
                    style="border-radius: 20px !important"
                    class="
                      intro-x
                      cursor-pointer
                      box
                      relative
                      flex
                      items-center
                      p-5
                      mt-5
                    "
                  >
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                      <img
                        v-if="person.avatar != null"
                        alt="Midone Tailwind HTML Admin Template"
                        class="rounded-full"
                        :src="
                          'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
                          person.avatar
                        "
                      />
                      <img
                        v-else
                        alt="Avatar"
                        class="rounded-full"
                        :src="'../dist2/images/avatardefault_92824-removebg.png'"
                      />
                      <div
                        :class="
                          onlineuser.find(
                            (onlineusers) => onlineusers.id === person.user_id
                          )
                            ? 'w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white'
                            : 'w-3 h-3 absolute right-0 bottom-0 rounded-full border-2 border-white disable-user'
                        "
                      ></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                      <div class="flex items-center">
                        <a href="javascript:;" class="font-medium">{{
                          person.name
                        }}</a>
                      </div>
                      <div class="mt-1 text-xs text-theme-21">
                        <div
                          v-for="(latestMsg, index) in allmessage"
                          :key="latestMsg.id"
                        >
                          <div v-if="index == allmessage.length - 1">
                            {{
                              latestMsg.receiver_id !== currentuser.id
                                ? "You: " + latestMsg.message
                                : latestMsg.user.name +
                                  ": " +
                                  latestMsg.message.substring(0, 25) +
                                  " ..."
                            }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="ml-2">
                      <button
                        class="btn btn-sm btn-rounded-danger messageNotyf"
                        v-if="person.unread"
                      >
                        {{ person.unread }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else>
                <div>
                  <div
                    style="border-radius: 20px !important"
                    class="
                      intro-x
                      cursor-pointer
                      box
                      relative
                      flex
                      items-center
                      p-5
                      mt-5
                      no-user-found
                    "
                  >
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                      <i
                        class="fa fa-exclamation-triangle"
                        aria-hidden="true"
                      ></i>
                    </div>
                    <div class="ml-2 overflow-hidden">
                      <div class="flex items-center">
                        <a href="javascript:;" class="font-medium"
                          >Sorry! No user found.</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- </div> -->
            </div>
          </div>
          <div
            id="friends"
            class="tab-pane"
            role="tabpanel"
            aria-labelledby="friends-tab"
          >
            <form v-on:submit.prevent="invitefriend">
              <div class="pr-1">
                <div class="box p-5 mt-5">
                  <div class="relative text-gray-700 dark:text-gray-300">
                    <input
                      v-model="friendemail"
                      type="text"
                      class="
                        form-control
                        py-3
                        px-4
                        border-transparent
                        bg-gray-200
                        pr-10
                        placeholder-theme-13
                      "
                      placeholder="Enter user's email"
                    />
                    <i
                      class="
                        w-4
                        h-4
                        hidden
                        sm:absolute
                        my-auto
                        inset-y-0
                        mr-3
                        right-0
                      "
                      data-feather="search"
                    ></i>
                  </div>
                  <button
                    style="background-color: #524eee !important"
                    type="submit"
                    class="btn btn-primary mt-3"
                  >
                    <i
                      v-if="loading"
                      class="fas fa-circle-notch fa-spin mr-1"
                    ></i>
                    <i v-else class="fas fa-user-plus mr-1"></i>
                    Invite Friend
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div
            id="profile"
            class="tab-pane"
            role="tabpanel"
            aria-labelledby="profile-tab"
          >
            <!-- <div
              class="chat__user-list overflow-y-auto scrollbar-hidden pr-1 pt-1"
            > -->
            <div class="mt-4 text-gray-600">Notification</div>
            <div v-if="notify != ''">
              <div
                style="
                  border-left: 6px solid #02de6b;
                  border-radius: 5px !important;
                "
                v-for="(noti, index) in notify"
                :key="noti.id"
                class="cursor-pointer box relative flex items-center p-5 mt-5"
              >
                <div class="ml-2 overflow-hidden">
                  <div class="flex items-center">
                    <a href="" class="font-medium"
                      ><i
                        id="user-plus"
                        class="fa fa-user-plus"
                        aria-hidden="true"
                      ></i>
                      {{ noti.user.name }} {{ noti.content }}</a
                    >
                  </div>
                </div>
                <div class="dropdown ml-auto">
                  <a
                    class="dropdown-toggle w-5 h-5 block"
                    href="javascript:;"
                    aria-expanded="false"
                  >
                    <i class="fas fa-ellipsis-v"></i
                  ></a>
                  <div class="dropdown-menu w-40 dropdown-action">
                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                      <a
                        @click="acceptRequest(noti, index)"
                        class="
                          flex
                          items-center
                          block
                          p-2
                          transition
                          duration-300
                          ease-in-out
                          bg-white
                          dark:bg-dark-1
                          hover:bg-gray-200
                          dark:hover:bg-dark-2
                          rounded-md
                        "
                      >
                        <i data-feather="share-2" class="w-4 h-4 mr-2"></i>
                        Accept
                      </a>
                      <a
                        @click="removeRequest(noti.id, noti.user_id, index)"
                        class="
                          flex
                          items-center
                          block
                          p-2
                          transition
                          duration-300
                          ease-in-out
                          bg-white
                          dark:bg-dark-1
                          hover:bg-gray-200
                          dark:hover:bg-dark-2
                          rounded-md
                        "
                      >
                        <i data-feather="copy" class="w-4 h-4 mr-2"></i> Remove
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-else>
              <div
                style="
                  border-left: 6px solid #6e6d7a;
                  border-radius: 5px !important;
                "
                class="cursor-pointer box relative flex items-center p-5 mt-5"
              >
                <div class="ml-2 overflow-hidden">
                  <div class="flex items-center">
                    <a href="" class="font-medium"
                      ><i class="fa fa-bell-o" aria-hidden="true"></i> No
                      Notification</a
                    >
                  </div>
                </div>
              </div>
            </div>

            <!-- </div> -->
          </div>
        </div>
      </div>
      <!-- END: Chat Side Menu -->

      <!-- BEGIN: Chat Content -->
      <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="chat__box box">
          <!-- BEGIN: Chat Active -->

          <div v-if="activeuser.length !== 0" class="h-full flex flex-col">
            <div
              class="
                flex flex-col
                sm:flex-row
                border-b border-gray-200
                dark:border-dark-5
                px-5
                py-4
              "
            >
              <div class="flex items-center">
                <div
                  class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative"
                >
                  <img
                    v-if="userchoose.avatar != null"
                    alt="Midone Tailwind HTML Admin Template"
                    class="rounded-full"
                    :src="
                      'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
                      userchoose.avatar
                    "
                  />
                  <img
                    v-else
                    alt="Avatar"
                    class="rounded-full"
                    :src="'../dist2/images/avatardefault_92824-removebg.png'"
                  />
                </div>
                <div class="ml-3 mr-auto">
                  <div class="font-medium text-base">
                    {{ userchoose.displayName }}
                  </div>
                  <div
                    v-if="userchoose.shortDescription != null"
                    class="text-gray-600 text-xs sm:text-sm"
                  >
                    {{ userchoose.shortDescription.substring(0, 50) + "..." }}

                    <div
                      :class="
                        onlineuser.find(
                          (onlineusers) => onlineusers.id === userchoose.user_id
                        )
                          ? 'w-3 h-3 bg-theme-9 absolute rounded-full mt-1'
                          : 'w-3 h-3 absolute rounded-full mt-1 disable-user'
                      "
                    ></div>
                    <div class="ml-4">
                      {{
                        onlineuser.find(
                          (onlineusers) => onlineusers.id === userchoose.user_id
                        )
                          ? "User Online"
                          : "User Offline"
                      }}
                    </div>
                  </div>
                  <div v-else class="text-gray-600 text-xs sm:text-sm">
                    Some quotes...
                    <span class="mx-1">•</span>
                    {{
                      onlineuser.find(
                        (onlineusers) => onlineusers.id === userchoose.user_id
                      )
                        ? "Online"
                        : "Offline"
                    }}
                  </div>
                </div>
              </div>
              <div
                class="
                  flex
                  items-center
                  sm:ml-auto
                  mt-5
                  sm:mt-0
                  border-t
                  sm:border-0
                  border-gray-200
                  pt-3
                  sm:pt-0
                  -mx-5
                  sm:mx-0
                  px-5
                  sm:px-0
                "
              >
                <a
                  @click="$router.push(`/otherprofile/${userchoose.user_id}`)"
                  class="dropdown-toggle w-4 h-4 text-gray-600"
                  aria-expanded="false"
                >
                  <i class="fas fa-info-circle fa-lg"></i>
                </a>
                <div class="dropdown-menu w-40">
                  <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                    <a
                      href=""
                      class="
                        flex
                        items-center
                        block
                        p-2
                        transition
                        duration-300
                        ease-in-out
                        bg-white
                        dark:bg-dark-1
                        hover:bg-gray-200
                        dark:hover:bg-dark-2
                        rounded-md
                      "
                    >
                      <i data-feather="corner-up-left" class="w-4 h-4 mr-2"></i>
                      Reply
                    </a>
                    <a
                      href=""
                      class="
                        flex
                        items-center
                        block
                        p-2
                        transition
                        duration-300
                        ease-in-out
                        bg-white
                        dark:bg-dark-1
                        hover:bg-gray-200
                        dark:hover:bg-dark-2
                        rounded-md
                      "
                    >
                      <i class="fas fa-trash"></i> <span>Delete</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div
              ref="privateMessage"
              class="overflow-y-scroll scrollbar-hidden px-5 pt-5 flex-1"
            >
              <div
                v-for="message in allmessage"
                :key="message.id"
                class="yourchat_loop"
              >
                <div
                  :class="
                    activeuser.id !== message.user_id
                      ? 'chat__box__text-box flex items-end float-right mb-5'
                      : 'chat__box__text-box flex items-end float-left mb-5'
                  "
                >
                  <div
                    class="
                      w-10
                      h-10
                      hidden
                      sm:block
                      flex-none
                      image-fit
                      relative
                      mr-5
                    "
                  >
                    <img
                      v-if="
                        currentuser.id == message.receiver_id &&
                        userchoose.avatar != null
                      "
                      alt="Midone Tailwind HTML Admin Template"
                      class="rounded-full"
                      :src="
                        'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
                        userchoose.avatar
                      "
                    />
                    <img
                      v-else-if="
                        currentuser.id == message.receiver_id &&
                        userchoose.avatar == null
                      "
                      alt=""
                      class="rounded-full"
                      :src="'../dist2/images/avatardefault_92824-removebg.png'"
                    />
                  </div>
                  <div
                    :class="
                      activeuser.id !== message.user_id
                        ? 'bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md'
                        : 'bg-gray-200 dark:bg-dark-5 px-4 py-3 text-gray-700 dark:text-gray-300 rounded-r-md rounded-t-md'
                    "
                  >
                    {{ message.message }}
                    <div class="mt-1 text-xs text-theme-21">
                      {{ message.created_at | formatDate }}
                    </div>
                    <!-- <div v-if="activeuser.id !== message.user_id">
                      <i
                        :class="
                          message.read == true
                            ? 'fa fa-eye mt-2'
                            : 'fa fa-check mt-2'
                        "
                        aria-hidden="true"
                      >
                      </i>
                      {{ message.read == true ? "seen" : "received" }}
                    </div> -->
                  </div>
                </div>

                <div class="clear-both"></div>
              </div>
            </div>

            <div
              class="
                pt-4
                pb-10
                sm:py-4
                flex
                items-center
                border-t border-gray-200
                dark:border-dark-5
              "
            >
              <textarea
                v-model="message"
                @keyup.enter="sendMessage"
                class="
                  chat__box__input
                  form-control
                  dark:bg-dark-3
                  h-16
                  resize-none
                  border-transparent
                  px-5
                  py-3
                  shadow-none
                  focus:ring-0
                "
                rows="1"
                placeholder="Type your message..."
              ></textarea>
              <div
                class="
                  flex
                  absolute
                  sm:static
                  left-0
                  bottom-0
                  ml-5
                  sm:ml-0
                  mb-5
                  sm:mb-0
                "
              >
                <div class="dropdown mr-3 sm:mr-5">
                  <a
                    @click="ToggleEmoji"
                    class="
                      dropdown-toggle
                      w-4
                      h-4
                      sm:w-5 sm:h-5
                      block
                      text-gray-600
                    "
                    aria-expanded="false"
                  >
                    <i class="fas fa-laugh fa-lg"></i>
                  </a>

                  <div class="floating-div">
                    <picker v-if="emoStatus" @select="addEmoji" />
                  </div>
                </div>

                <!-- <div class="w-4 h-4 sm:w-5 sm:h-5 relative text-gray-600 mr-3 sm:mr-5">
                                            <i data-feather="paperclip" class="w-full h-full"></i> 
                                            <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                                        </div> -->
              </div>

              <a
                @click="sendMessage"
                type="button"
                class="
                  w-8
                  h-8
                  sm:w-10 sm:h-10
                  block
                  bg-theme-1
                  text-white
                  rounded-full
                  flex-none flex
                  items-center
                  justify-center
                  mr-5
                "
                ><i class="fas fa-paper-plane"></i>
              </a>
            </div>
          </div>

          <!-- END: Chat Active -->
          <!-- BEGIN: Chat Default -->
          <div v-else class="h-full flex items-center">
            <div class="mx-auto text-center">
              <div class="">
                <img
                  style="height: 400px; width: 400px"
                  class="emptychatimg"
                  alt="Midone Tailwind HTML Admin Template"
                  v-bind:src="'dist2/images/messagingcp.png'"
                />

                <!-- <div class="font-medium">Hey, {{currentuser.name}}</div> -->
                <div class="text-gray-600 mt-1">
                  Please select a chat to start messaging.
                </div>
              </div>
            </div>
          </div>
          <!-- END: Chat Default -->
        </div>
      </div>
      <!-- END: Chat Content -->
    </div>
  </div>
</template>

<script>
import { Picker } from "emoji-mart-vue";

export default {
  components: {
    Picker,
  },
  data() {
    return {
      users: [],
      activeuser: [],
      allmessage: [],
      loading: false,
      message: null,
      currentuser: [],
      userchoose: {},
      profile: [],
      friendemail: "",
      emoStatus: false,
      onlineuser: [],
      notify: [],
      keywords: "",
      unreadCount: "",
    };
  },
  created() {
    Echo.join("bffchat")
      .here((users) => {
        this.onlineuser = users;
      })
      .joining((user) => {
        this.onlineuser.push(user);
      })
      .leaving((user) => {
        this.onlineuser.splice(this.onlineuser.indexOf(user), 1);
      })
      .error((error) => {
        console.error(error);
      });

    Echo.private(`privatebffchat.${UserAuth.id}`).listen(
      "PrivateMessageSent",
      (e) => {
        this.handleMessage(e.message);
        // this.allmessage.push(e.message);
      }
    );

    Echo.private(`bffchatnotify.${UserAuth.id}`).listen("NotifyEvent", (e) => {
      this.notify.unshift(e.notify);
      Toast.fire({
        icon: "info",
        title: "You have a friend request!",
      });
    });

    Echo.private(`bffchatacceptuser.${UserAuth.id}`).listen(
      "AcceptUser",
      (e) => {
        this.users.unshift(e.acceptuser);
        let notifyTab = document.getElementById("profile-tab");
        notifyTab.classList.remove("active");
        let notifyTabPane = document.getElementById("profile");
        notifyTabPane.classList.remove("active");
        let chatTab = document.getElementById("chats-tab");
        chatTab.classList.add("active");
        let chatTabPane = document.getElementById("chats");
        chatTabPane.classList.add("active");
      }
    );

    Echo.private(`bffchatacceptsubuser.${UserAuth.id}`).listen(
      "AcceptSubUser",
      (e) => {
        this.users.unshift(e.acceptsubuser);
        Toast.fire({
          icon: "success",
          title: "Friend request accepted, let's start chatting.",
        });
        let notifyTab = document.getElementById("profile-tab");
        notifyTab.classList.remove("active");
        let notifyTabPane = document.getElementById("profile");
        notifyTabPane.classList.remove("active");
        let chatTab = document.getElementById("chats-tab");
        chatTab.classList.add("active");
        let chatTabPane = document.getElementById("chats");
        chatTabPane.classList.add("active");
      }
    );
    this.getUserProfile();
    this.fetchUser();
    this.getnotify();
  },
  watch: {
    activeuser(val) {
      this.fetchmessage();
    },
    keywords(after, before) {
      this.searchuser();
    },
    allmessage(val) {
      this.scrollToEnd();
      // this.fetchmessage();
    },
  },
  methods: {
    saveMessage(message) {
      this.allmessage.push(message);
    },
    handleMessage(message) {
      if (this.activeuser && message.user_id == this.activeuser.id) {
        this.saveMessage(message);
        return;
      }

      // toast new quantity of unread message
      this.updateStateUnread(message.user, false);
    },
    logout() {
      axios
        .get("/logout")
        .then((res) => {
          window.location.reload();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    searchuser() {
      axios
        .get("/search", { params: { keywords: this.keywords } })
        .then((res) => {
          // let data = Object.assign({},res.data);
          this.users = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    removeRequest(id, userid, index) {
      axios
        .delete(`/remove-request?noti=${id}&uid=${userid}`)
        .then((res) => {
          let actionDropdown = document.querySelector(
            ".dropdown-menu.w-40.dropdown-action.show"
          );
          actionDropdown.classList.remove("show");
          Toast.fire({
            icon: "success",
            title: "Friend request successfully removed!",
          });
          this.notify.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    acceptRequest(noti, index) {
      let userid = noti.user_id;
      let id = noti.id;
      const data = {
        userid: userid,
      };
      axios
        .post("/accept-request/" + id, data)
        .then((res) => {
          let actionDropdown = document.querySelector(".dropdown-action");
          actionDropdown.classList.remove("show");
          Toast.fire({
            icon: "success",
            title: "You have a new friend, Start a conversation!",
          });
          this.notify.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    invitefriend() {
      if (!this.friendemail) {
        Toast.fire({
          icon: "error",
          title: "Enter your friend email first and then submit",
        });
      } else {
        const data = {
          email: this.friendemail,
        };

        this.loading = !this.loading;

        setTimeout(() => {
          axios
            .post("/sendfriendrequest", data)
            .then((res) => {
              if (res.data.error) {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "error",
                  title: res.data.error,
                });
              } else if (res.data.selferror) {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "error",
                  title: res.data.selferror,
                });
              } else if (res.data.exist) {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "warning",
                  title: res.data.exist,
                });
              } else if (res.data.waiting) {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "warning",
                  title: res.data.waiting,
                });
              } else {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "success",
                  title: res.data.status,
                });
                this.friendemail = "";
              }
            })
            .catch((err) => {
              console.log(err);
            });
        }, 2000);
      }
    },
    ToggleEmoji() {
      this.emoStatus = !this.emoStatus;
    },
    addEmoji(e) {
      if (!e) {
        return false;
      }
      if (!this.message) {
        this.message = e.native;
      } else {
        this.message = this.message + e.native;
      }
    },
    fetchmessage() {
      this.updateStateUnread(this.activeuser, true);
      axios
        .get(`/private-message/${this.activeuser.id}`)
        .then((res) => {
          this.allmessage = res.data.messages;
          this.unread = res.data.countunread;
          this.userchoose = res.data.userchat[0];
        })
        .catch((err) => {
          Toast.fire({
            icon: "error",
            title: "Something went wrong!",
          });
        });
    },
    fetchUser() {
      axios
        .get("/users")
        .then((res) => {
          this.users = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    scrollToEnd() {
      //   document.getElementById('private__message').scrollTo(0, 999999);
      setTimeout(() => {
        this.$refs.privateMessage.scrollTop =
          this.$refs.privateMessage.scrollHeight -
          this.$refs.privateMessage.clientHeight;
      }, 50);
    },
    getUserProfile() {
      axios
        .get("/getuserprofile")
        .then((res) => {
          this.profile = res.data.user[0];
          this.currentuser = res.data.currentUser[0];
        })
        .catch((err) => {
          Toast.fire({
            icon: "error",
            title: "Opps! something went wrong",
          });
        });
    },
    deleteMessage(id, index) {
      axios
        .delete(`/delete-message/${id}`)
        .then((res) => {
          this.allmessage.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    fetchDataMessage() {
      axios
        .get("/messages")
        .then((res) => {
          this.initialMessage = res.data;
        })
        .catch((err) => {
          // Toast.fire({
          //   icon: "error",
          //   title: "Something went wrong!",
          // });
          console.log(err);
        });
    },
    getnotify() {
      axios
        .get("/getallnotify")
        .then((res) => {
          this.notify = res.data.reverse();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    sendMessage() {
      if (!this.message) {
        Toast.fire({
          icon: "error",
          title: "You need to fill your message first!",
        });
      }
      const msg = {
        message: this.message,
      };
      axios
        .post("/private-message/" + this.activeuser.id, msg)
        .then((res) => {
          this.message = null;
          this.allmessage.push(res.data.message);

          setTimeout(this.scrollToMessage, 10);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    updateStateUnread(user, reset) {
      this.users = this.users.map((singleUser) => {
        if (singleUser.id !== user.id) {
          return singleUser;
        }
        if (reset) {
          singleUser.unread = 0;
        } else {
          singleUser.unread += 1;
        }
        return singleUser;
      });
    },
  },
  computed: {
    sortUnreadContact() {
      return _.sortBy(this.users, [
        (contact) => {
          return contact.unread;
        },
      ]).reverse();
    },
  },
};
</script>

<style scoped>
.chat .chat__tabs a.active {
  background-color: #3e94da !important;
}
.bg-theme-1 {
  background-color: #1d90f4 !important;
}

.box.active {
  border-left: 6px solid #02de6b !important;
}
.no-user-found {
  border-left: 6px solid #e3175b !important;
}
.box {
  border-radius: 20px;
}

.emoji-mart[data-v-7bc71df8] {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", sans-serif;
  font-size: 16px;
  display: -ms-flexbox;
  box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px,
    rgba(0, 0, 0, 0.05) 0px 5px 10px;
  display: flex;
  -ms-flex-direction: column;
  flex-direction: column;
  height: 420px;
  color: #222427;
  border: 1px solid #293145;
  border-radius: 20px;
  background-color: #293145;
}

.emoji-mart-category-label {
  border-radius: 20px !important;
}
/* .emoji-mart-category-label span {
    background-color: #3e94da !important;
    color: #293145 !important;
    border-radius: 10px !important;
} */
.friendNotyf {
  height: 20px;
  position: relative;
  right: 5px;
  background-color: #e3175b;
  border-color: #e3175b;
}
.messageNotyf {
  height: 20px;
  background-color: #e3175b;
  border-color: #e3175b;
}
#user-plus {
  color: #02dc6b;
}
.disable-user {
  background-color: #6e6d7a;
}
.fa-exclamation-triangle {
  font-size: 50px;
  color: #e3175b;
}
.fa-check {
  font-size: 10px;
}
.fa-eye {
  font-size: 10px;
}
</style>