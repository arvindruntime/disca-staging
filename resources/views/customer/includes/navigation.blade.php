<main class="main-content" id="main">
  <div class="di__dashboard d-flex">
    <aside class="p-3 bg-white di__dashboard-sidebar min-vh-100" style="width: 260px;">
      <div class="d-flex align-items-center di__user di__user--live">
        <a href="#" class="d-block">
          <div class="d-flex align-items-center text-decoration-none ms-3 ">
            <div class="img-wrapper me-2">
              <img src="{{ asset('images/icon/user_img.png') }}" alt="" width="55" height="55" class="rounded-circle bg-primary">
            </div>
            <p class="mb-0 tertiary-color">
              <strong>David John</strong>
            </p>
          </div>
        </a>
      </div>
      <div class="d-flex align-items-center di__user di__user_persons di__user_disbale  ms-3 mt-3 mb-1">
        <a href="#" class="d-block">
          <div class="d-flex align-items-center text-decoration-none">
            <div class="img-wrapper me-2">
              <img src="{{ asset('images/icon/user_img.png') }}" alt="" width="40" height="40" class="rounded-circle bg-primary">
            </div>
            <p class="mb-0 tertiary-color">
              <strong>Tom Jones</strong>
            </p>
          </div>
        </a>
      </div>
      <ul class="nav nav-pills flex-column mt-3 px-1">
        <li class="nav-item">
          <a href="#" class="nav-link active mb-1 fw-medium" aria-current="page">
            Dashboard
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-xs fw-medium tertiary-color mb-1">
            Apply for Care
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-xs fw-medium tertiary-color mb-1">
            My Agreed Care Package
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-xs fw-medium tertiary-color mb-1">
            GP and Pharmacy
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-xs fw-medium tertiary-color mb-1">
            Care Provider Offers
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-xs fw-medium tertiary-color mb-1">
            Messages
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-xs fw-medium tertiary-color mb-1">
            Power of Attorney
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-xs fw-medium tertiary-color">
            Mobile App
          </a>
        </li>
      </ul>
      <hr class="bg-grey opacity-100">
      <div class="d-flex align-items-center justify-content-center gap-3 mt-3">
        <form id="logout-form" action="{{ route('logout') }}" method="post">@csrf</form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn di__sidebar-btn text-xs fw-medium lh-base">Logout</a>
        <a href="" class="btn di__sidebar-btn text-xs fw-medium lh-base"><img src="../images/icon/border-user.svg" alt="" height="15" width="15" class="me-1">Account</a>
      </div>
    </aside>
  