<!-- Modal -->
<div id="viewMoney" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">My money</h4>
      </div>
      <div class="modal-body">
        <p>Total Bonus: {{ ($data["total_bonus"]) ? $data["total_bonus"] : "0" }}$</p>
        <p>Spending by bonus money: {{ ($data["total_spending"]) ? $data["total_spending"] : "0" }}$</p>
        <p>My money: {{ ($model->user_money) ? $model->user_money : 0 }}$</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>