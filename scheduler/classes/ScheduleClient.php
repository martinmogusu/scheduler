<?php

class ScheduleClient{
  private $con;
  private $pool_threshold = 63; // Threshold for pool allocations
  private $user_seed_total = 10;
  private $request_seed_total = 18;
  private $allocation_seed_total = 18;

  public function __construct(){
    include_once('connect.php');
    $this->con = $con;

    $this->first_names = ["addison", "adrian", "ainsley", "alex", "andy", "angel", "ashley", "ashton", "aubrey", "avery", "bailey", "bevan", "blair", "bobby", "brett", "brooke", "bronwyn", "cameron", "carson", "casey", "cassidy", "charlie", "chris", "dakota", "dallas", "dana", "darby", "dawson", "devon", "drew", "eden", "ellis", "emery", "emerson", "erin", "finley", "francis", "gene", "gillian", "greer", "hayden", "harlow", "harper", "holland", "hunter", "indigo", "jaden", "jackie", "jamie", "jan", "jesse", "joe", "jody", "jordan", "journey", "julian", "justice", "kai", "keegan", "keely", "keelan", "kei", "keith", "kelly", "kelsey", "kendall", "kennedy", "kensley", "kerry", "kevin", "kieran", "kiley", "kim", "kyle", "lane", "lee", "leslie", "logan", "loren", "macey", "madison", "marley", "marlow", "merritt", "michael", "micky", "montana", "morgan", "nevada", "nico", "owen", "paris", "parker", "pat", "peyton", "phoenix", "piper", "quinn", "rayne", "regan", "rene", "reese", "riley", "robin", "rory", "rowan", "ryan", "sage", "sasha", "scout", "shae", "shannon", "sloan", "skylar", "sydney", "shawn", "storm", "tate", "tatum", "taylor", "tony", "tory", "tracy", "trinity", "tristan", "vick", "wesley", "whitney"]; 

    $this->last_names = ["mwangi", "maina", "kamau", "otieno", "kariuki", "njoroge", "kimani", "ochieng", "odhiambo", "omondi", "onyango", "njuguna", "macharia", "karanja", "wanjiru", "njeri", "wambui", "mutua", "juma", "chege", "mbugua", "ndungu", "wachira", "waweru", "wanjiku", "ngugi", "muthoni", "mburu", "mwaura", "gitau", "mungai", "shah", "kinyua", "njenga", "wambua", "mugo", "gitonga", "muriithi", "ouma", "kinyanjui", "njeru", "kuria", "muriuki", "mwaniki", "nyaga", "munene", "owino", "ndegwa", "muchiri", "wafula", "koech", "nganga", "okoth", "wairimu", "cheruiyot", "mutuku", "rotich", "langat", "mohamed", "atieno", "nyambura", "wangui", "achieng", "oduor", "hassan", "githinji", "kioko", "kirui", "musyoka", "patel", "irungu", "njoki", "wainaina", "simiyu", "wambugu", "akinyi", "wangari", "kiarie", "nderitu", "wanjohi", "ndirangu", "abdi", "njogu", "korir", "muiruri", "ali66,0", "mutai", "kinuthia", "mugambi", "okello", "njagi", "kibet", "muli", "opiyo", "mutinda", "ng’ang’a", "mwai", "were", "kyalo", "barasa", "rono", "mwenda", "okumu", "maingi", "muturi", "mathenge", "ndung’u", "mutisya", "bett", "hussein", "oluoch", "ogutu", "odongo", "wahome", "makau", "mwendwa", "kimathi", "wanjala", "owuor", "thuo", "wekesa", "momanyi", "karimi", "adhiambo", "oloo", "waithaka", "mwende", "musau", "munyao", "mureithi", "njiru", "musyoki", "mutiso", "wanja", "njau", "murithi", "odero", "gichuki", "moraa", "wanyonyi", "muema", "karani", "nyakundi", "kiragu", "makokha", "ahmed", "mbogo", "mulwa", "muigai", "kemboi", "murage", "mutunga", "ngure", "awuor", "kihara", "kilonzo", "ngetich", "makori", "omollo", "wanyoike", "kimeu", "anyango", "ngari", "nzioka", "nyongesa", "mumbi", "mumo odera", "murimi", "oyugi", "mbithi", "sang", "opondo", "ngigi", "owiti", "mbuthia", "thuku", "mueni", "kibe", "kiptoo", "kennedy", "okeyo", "kerubo", "muia", "chebet", "wanyama", "musembi", "njue", "omar", "ouko", "kiplagat", "tanui", "mwangangi", "kanyi", "kimutai", "nduta", "oketch", "kamande", "bosire", "ogola"];

    $this->request_titles = ["Safaricom API Access Request", "Request for non-standard software", "Request for standard software", "FTTH Customer Provisioning Request", "LAN Access", "Request Access to 6th Floor Bio metrics", "Request For FlyTxt Access", "New Employee", "M-Pesa Service Requests", "Inventory Adjustments Requests", "Report a Global Outage"];
  }

  private function seed_users(){
    /**
     * Create dummy users
     */
    
        $user_query = "INSERT INTO users (username, email, password, userlevel, status, expire) VALUES ";
        for($i = 0; $i < $this->user_seed_total; $i++){

          $letter = chr(rand(97, 122));
          $index = rand(0, count($this->last_names) - 1);
          $lastname = $this->last_names[$index];
          $username = $letter . $lastname;
          $email = $username . '@safaricom.co.ke';
          $telephone = null;
          $password = 'pass';
          $userlevel = 'user';
          $status = 'pending';
          $expire = '2019-06-14 17:02:24';
          $user = new User($username, $email, $telephone, $password, $userlevel, $status, $expire);
          $user_query .= "('" . $user->username . "', '" . $user->email . "', '" . $user->password . "', '" . $user->userlevel . "', '" . $user->status . "', '" . $user->expire . "'), ";
          
        }
        
        // Remove trailing comma
        $user_query = substr($user_query, 0, -2);
        
        // Delete existing dummy users
        $user_delete_query = "DELETE FROM users WHERE status = 'pending'";
        $this->con->query($user_delete_query);
        
        // Add new users
        $result = $this->con->query($user_query);
        if($result){
          echo $this->con->affected_rows . " users added<br>";
        } else {
          echo "Error inserting users - ".$this->con->error . "<br>";
        }   
    
  }

  private function seed_requests(){
    /**
     * Create dummy requests
     */
    
    $user_id_list = [];
    $user_id_query = "SELECT userID FROM users";
    $result = $this->con->query($user_id_query);
    if(!$result){
      echo "Error fetching users - " . $this->con->error . "<br>";
    } else {

      // Delete existing requests
      $request_delete_query = "DELETE FROM requests";
      $delete_result = $this->con->query($request_delete_query);
      if(!$delete_result){
        echo "Error deleting requests - " . $this->con->error;
      } else {
        while($row = $result->fetch_object()){
          array_push($user_id_list, $row->userID);
        }

      // Add new requests

        $request_query = "INSERT INTO requests (req, staff, title, time_created, status, email, phone, estimated_duration) VALUES ";

        for($i = 4; $i <= $this->request_seed_total; $i++){
          $crq = $i;
          $staff = "New Staff";
          $id_index = rand(0, count($user_id_list) - 1);
          $title_index = rand(0, count($this->request_titles) - 1);
          $user_id = $user_id_list[$id_index];
          $title = $this->request_titles[$title_index];
          $time_created = date('Y-m-d H:'. $i * 3 . ':S');
          $time_allocated = '2018-10-19 17:00:00';
          $email = 'staff@safaricom.co.ke';
          $phone = '';
          $estimated_duration = 5 * rand(1, 9); // Random minutes in steps of 5 (5 - 45)
          $status = 'pending';

          $request = new Request($crq, $user_id, $title, $time_created, $estimated_duration, $status);
          $request_query .= "('" . $request->crq . "', '" . $staff . "', '" . $request->title . "', '" . $request->time_created . "', '" . $status . "', '" . $email . "', '" . $phone . "', '" . $request->estimated_duration . "'), ";
        }
        
        $request_query = substr($request_query, 0, -2);
        $result = $this->con->query($request_query);
        if(!$result){
          echo "Error inserting requests - " . $this->con->error;
        } else {
          echo $this->con->affected_rows . " requests added<br>";
        }
      }
    }
  }

  private function seed_allocations(){
    /**
     * Create dummy allocations
     */
    
    // Get requests
    $request_list_query = "SELECT * FROM requests ORDER BY time_created";
    $request_list_result = $this->con->query($request_list_query);
    $requests = [];
    while($row = $request_list_result->fetch_object()){
      array_push($requests, $row);
    }

    // Get pools
    $pool_list_query = "SELECT * FROM pools";
    $pool_list_result = $this->con->query($pool_list_query);
    $pools = [];
    while($row = $pool_list_result->fetch_object()){
      array_push($pools, $row);
    }

    // Create agents
    $agents = [];
    for($i = 0; $i < $this->allocation_seed_total; $i++){
      $firstname_index = rand(0, count($this->first_names) - 1);
      $firstname = $this->first_names[$firstname_index];
      $lastname_index = rand(0, count($this->last_names) - 1);
      $lastname = $this->last_names[$lastname_index];
      $username = substr($firstname, 0, 1) . $lastname;

      $fullname = ucfirst($firstname) . " " . ucfirst($lastname); 
      $phone = '0722003333';
      $email = $username . '@safaricom.co.ke';
      $agent = new Agent($username, $fullname, $phone, $email);
      array_push($agents, $agent);
    }


    // Clear allocations
    $allocations_delete_query = "DELETE FROM allocations";
    $this->con->query($allocations_delete_query);

    // Allocate requests to pools
    $pool_quota = 0;
    $pool_index = 0;
    $allocation_query = "INSERT INTO allocations (request_id, pool_id, agent_name, agent_email, agent_phone, allocation_time, status) VALUES ";
    foreach ($requests as $request) {
      if($this->pool_threshold - $pool_quota < $request->estimated_duration){
        $pool_index ++;
      }

      if($pool_index > count($pools) - 1){
        // Maximum requests that can be sorted per day reached.
        break;
      }


      $pool_quota += $request->estimated_duration;
      // array_push($allocations[$pools[$pool_index]->start_time], $request);

      $request_id = $request->rID;
      $pool_id = $pools[$pool_index]->id;
      $agent_index = rand(0, count($agents) - 1);
      $agent = $agents[$agent_index];
      $agent_name = $agent->fullname;
      $agent_phone = $agent->phone;
      $agent_email = $agent->email;
      $allocation_time = date('Y-m-d H:i:s');
      $closing_time = null;
      $status = 'open';
      $allocation = new Allocation($request_id, $pool_id, $allocation_time, $closing_time, $status);
      $allocation_query .= "('" . $allocation->request_id . "', '" . $allocation->pool_id . "', '" . $agent_name . "', '" . $agent_email . "', '" . $agent_phone . "', '" . $allocation->allocation_time . "', '" . $status . "'), ";
    }

    $allocation_query = substr($allocation_query, 0, -2);
    $result = $this->con->query($allocation_query);

    if(!$result){
      echo "Error adding allocations - " . $this->con->error;
    } else {
      echo $this->con->affected_rows . " allocations added<br>";
    }
  }

  public function seed(){
    echo "Seeding...";
    echo "<br>";
    $this->seed_users();
    $this->seed_requests();
    $this->seed_allocations();
  }

  public function get_allocations(){
    /**
     * Gets a list of allocations, grouped per pool
     */
    $allocations = [];

    $query = "SELECT p.id as pool_id, p.start_time as pool_start_time, p.end_time as pool_end_time, r.title, r.estimated_duration, a.* FROM allocations a join pools p on p.id = a.pool_id JOIN requests r on r.rID = a.request_id";

    $result = $this->con->query($query);
    if($result){
      if($result->num_rows > 0){
        while($row = $result->fetch_object()){
          array_push($allocations, $row);
        }
      }
    }

    return $allocations;
  }

  public function get_allocation($request_id){
    /**
     * Returns the allocation associated with a request.
     * If none returns null
     */
    
    $allocation = null;
    $query = "SELECT request_id, agent_name, agent_email, agent_phone, p.start_time as pool_start_time, p.end_time as pool_end_time, r.title, r.estimated_duration FROM allocations a JOIN requests r ON r.rID = a.request_id  JOIN pools p ON p.id = a.pool_id WHERE r.req = " . $request_id;
    $result = $this->con->query($query);
    if($result){
      if($result->num_rows > 0){
        $allocation = $result->fetch_object();
      }
    }

    return $allocation;
  }

  public function get_pools(){
    /**
     * Returns a list of all available pools
     */
    $pools = [];

    $query = "SELECT * FROM pools";

    $result = $this->con->query($query);
    if($result){
      if($result->num_rows > 0){
        while($row = $result->fetch_object()){
          array_push($pools, $row);
        }
      }
    }

    return $pools;
  }
}

?>