rndefine("#RNAUTOWorkflowEntryManager",["#RNAUTOCore/EventManager","#RNAUTOPreMadeDialogs/ConfirmDialog","#RNAUTOCore/WpAjaxPost","lit"],(function(e,t,r,n){"use strict";class o extends class{constructor(e){this.Container=e}UpdatePanel(e){let t=document.createElement("div");t.innerHTML=e;let r=this.Container;this.Container=t.firstElementChild,r.replaceWith(this.Container),a.MaybeCreateWorkflowProcessor(this.Container)}}{constructor(e){var o,a;super(e),null===(o=this.Container.querySelector(".approveAction"))||void 0===o||o.addEventListener("click",(e=>{e.preventDefault(),t.ConfirmDialog.Show("Approve?",n.html`Are you sure you want to <span style="color:#28a745">APPROVE</span> this entry?`,(async()=>{let t=await r.WpAjaxPost.Post("ProcessWorkflow",{String:e.target.getAttribute("data-string")},"",null,{Prefix:"RNAUTO"});return null!=t&&null!=t.Panel&&this.UpdatePanel(t.Panel),!0}))})),null===(a=this.Container.querySelector(".rejectAction"))||void 0===a||a.addEventListener("click",(e=>{e.preventDefault(),t.ConfirmDialog.Show("Reject?",n.html`Are you sure you want to <span style="color:#dc3545">REJECT</span> this entry?`,(async()=>{let t=await r.WpAjaxPost.Post("ProcessWorkflow",{String:e.target.getAttribute("data-string")},"",null,{Prefix:"RNAUTO"});return null!=t&&null!=t.Panel&&this.UpdatePanel(t.Panel),!0}))}))}}class a{static MaybeCreateWorkflowProcessor(e){switch(e.getAttribute("data-type")){case"approve":new o(e)}}}e.EventManager.Subscribe("EntryActionsLoaded",(()=>{document.querySelectorAll(".workflow").forEach(((e,t)=>{a.MaybeCreateWorkflowProcessor(e)}))}))}));
