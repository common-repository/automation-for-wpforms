rndefine("#RNAUTOWorkflowList",["exports","#RNAUTOCore/WpAjaxPost","lit/decorators","#RNAUTOCore/LitElementBase","lit","#RNAUTOWPTable/WPTableColumn","#RNAUTOPreMadeDialogs/DeleteDialog","#RNAUTODialog/DialogBase","#RNAUTODialog/Dialog","#RNAUTOLit/Lit","#RNAUTOTabs/RNTabItem"],(function(e,t,i,n,a,l,r,s,o,c,p){"use strict";var d={};!function(e){Object.defineProperty(e,"__esModule",{value:!0});var t="plus",i=[10133,61543,"add"],n="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z";e.definition={prefix:"fas",iconName:t,icon:[448,512,i,"2b",n]},e.faPlus=e.definition,e.prefix="fas",e.iconName=t,e.width=448,e.height=512,e.ligatures=i,e.unicode="2b",e.svgPathData=n,e.aliases=i}(d);var m,u={},h={};!function(e){Object.defineProperty(e,"__esModule",{value:!0});var t="magnifying-glass",i=[128269,"search"],n="f002",a="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z";e.definition={prefix:"fas",iconName:t,icon:[512,512,i,n,a]},e.faMagnifyingGlass=e.definition,e.prefix="fas",e.iconName=t,e.width=512,e.height=512,e.ligatures=i,e.unicode=n,e.svgPathData=a,e.aliases=i}(h),function(e){Object.defineProperty(e,"__esModule",{value:!0});var t=h;e.definition={prefix:t.prefix,iconName:t.iconName,icon:[t.width,t.height,t.aliases,t.unicode,t.svgPathData]},e.faSearch=e.definition,e.prefix=t.prefix,e.iconName=t.iconName,e.width=t.width,e.height=t.height,e.ligatures=t.aliases,e.unicode=t.unicode,e.svgPathData=t.svgPathData,e.aliases=t.aliases}(u),c.customElementOnce("rnwppages-license-required")(class extends s.DialogBase{constructor(...e){super(...e),this.message=""}InternalGetOptions(){return{Title:"Full version required",ShowApplyButton:!0,ShowCloseButton:!0,CloseButtonTitle:"Close",ApplyButtonTitle:"Get Full Version"}}SubRender(){return a.html`${this.message}`}async OnApply(){return window.open("https://formwiz.rednao.com/downloads/automation-for-wpforms/"),!0}static IsValid(e="Sorry this feature is only available in the full version"){return"1"==rnBuilderVar.IsPR||(o.Dialog.Show(a.html`<rnwppages-license-required .message="${e}"></rnwppages-license-required>`),!1)}static AddFullVersionText(e){return""==rnBuilderVar.IsPR?e+" (Full version only)":e}}),i.customElement("rn-template-item")(class extends n.LitElementBase{constructor(...e){super(...e),this.previewUrl=""}render(){return a.html` <div class="templateItem"> <div class="templateIconContainer" style="width: 100%;height: 200px;display: flex;align-items: center;justify-content: center;overflow: hidden;position:relative;border-bottom: 1px solid #ccc;"> <div class="templateIcon" style="height: 200px;display: flex;align-items: center;justify-content: center;width: 170px;"> ${this.icon} </div> ${c.rnIf(""!=this.previewUrl&&a.html` <div class="previewContainer" style="position: absolute;left: 0;bottom: 0;background-color: red;color:white;text-align: center;width: 100%;display: flex;align-items: center;justify-content: center;" @click="${e=>{e.preventDefault(),e.stopImmediatePropagation(),this.Preview()}}"> <div style="display: flex;align-items: center;justify-content: center;" > <rn-fontawesome style="margin-right: 3px" .icon="${u.faSearch}"></rn-fontawesome> Preview </div> </div> `)} </div> <label style="font-weight: bold;">${this.title}</label> <p>${this.description}</p> </div> `}Preview(){window.open(this.previewUrl)}}),i.customElement("rn-template-dialog")(class extends s.DialogBase{constructor(...e){super(...e),this.SelectedTab="Listing"}InternalGetOptions(){return{Title:"Select a template type",Styles:{width:"1200px",maxWidth:"80%"}}}SubRender(){return a.html` <h2 style="margin: 0;margin-bottom: 10px">Want to see what can be done with the plugin? <a target="_blank" href="https://demos.rednao.com/pagebuilder/">Check the demo gallery</a></h2> <rn-tabs .selectedTab="${this.SelectedTab}" @tabChanged=${e=>{this.SelectedTab=e.detail,this.forceUpdate()}} .tabs="${[new p.RNTabItem("Listing","Listing",null,a.html` <div style="display: flex;flex-direction: row;justify-content: center;flex-wrap: wrap;"> <rn-template-item class="blank" @click="${()=>this.SendResult({Type:"listing",SubType:"blank"})}" .title="${"Blank"}" .description="${"Create your template from scratch"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/blank.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/listing-demo/"}" @click="${()=>this.SendResult({Type:"listing",SubType:"basic"})}" .title="${"Basic"}" .description="${"Basic listing layout"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/basic_listing.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/movie-gallery/"}" @click="${()=>this.SendResult({Type:"listing",SubType:"gallery"})}" .title="${"Gallery"}" .description="${"Movie gallery layout"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/moviegallery.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/testimonials/"}" @click="${()=>this.SendResult({Type:"listing",SubType:"testimonials"})}" .title="${"Testimonials"}" .description="${"Show each item in a panel"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/testimonials_listing.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/multi-column/"}" @click="${()=>this.SendResult({Type:"listing",SubType:"bio"})}" .title="${"Bio"}" .description="${"Biography of people"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/bio_listing.png"/>`}"></rn-template-item> </div> `),new p.RNTabItem("Grid","Grid",null,a.html` <div style="display: flex;flex-direction: row;justify-content: center;flex-wrap: wrap;"> <rn-template-item class="blank" @click="${()=>this.SendResult({Type:"grid",SubType:"blank",IsPr:!1})}" .title="${"Blank"}" .description="${"Create your template from scratch"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/blank.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/grid-demo/"}" @click="${()=>this.SendResult({Type:"grid",SubType:"basic",IsPr:!1})}" .title="${"Basic"}" .description="${"Basic grid layout"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/basic_grid.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/grid-with-search-bar/"}" @click="${()=>this.SendResult({Type:"grid",SubType:"withsearchbar",IsPr:!0})}" .title="${"With search bar"}" .description="${"Grid with search bar (full only)"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/withsearch_grid.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/240-2/"}" @click="${()=>this.SendResult({Type:"grid",SubType:"satisfaction",IsPr:!0})}" .title="${"Satisfaction survey"}" .description="${"Grid with charts"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/satisfactionsurvey.png"/>`}"></rn-template-item> </div> `),new p.RNTabItem("Calendar","Calendar (Full version only)",null,a.html` <div style="display: flex;flex-direction: row;justify-content: center;flex-wrap: wrap;"> <rn-template-item class="blank" @click="${()=>this.SendResult({Type:"calendar",SubType:"blank",IsPr:!0})}" .title="${"Blank"}" .description="${"Create your template from scratch"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/blank.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/calendar-demo/"}" @click="${()=>this.SendResult({Type:"calendar",SubType:"basic",IsPr:!0})}" .title="${"Basic"}" .description="${"Basic calencar layout"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/basic_calendar.png"/>`}"></rn-template-item> </div> `),new p.RNTabItem("Single Entry","Single Entry (Full version only)",null,a.html` <div style="display: flex;flex-direction: row;justify-content: center;flex-wrap: wrap;"> <rn-template-item class="blank" @click="${()=>this.SendResult({Type:"single",SubType:"blank",IsPr:!0})}" .title="${"Blank"}" .description="${"Create your template from scratch"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/blank.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/show-single-page/?entryid=6"}" @click="${()=>this.SendResult({Type:"single",SubType:"basic",IsPr:!0})}" .title="${"Basic"}" .description="${"Basic single layout"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/basic_single.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/confirmation-page-2/?tid=14&entryid=32"}" @click="${()=>this.SendResult({Type:"single",SubType:"confirmation",IsPr:!0})}" .title="${"Confirmation"}" .description="${"Confirmation layout"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/confirmation_single.png"/>`}"></rn-template-item> <rn-template-item .previewUrl="${"https://demos.rednao.com/pagebuilder/approve-reject/?entryid=28"}" @click="${()=>this.SendResult({Type:"single",SubType:"approve-reject",IsPr:!0})}" .title="${"Approve/Reject entry"}" .description="${"Approve or reject an entry"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/approve_reject_single.png"/>`}"></rn-template-item> </div> `),new p.RNTabItem("EntryToPost","Entry to post or page",null,a.html` <div style="display: flex;flex-direction: row;justify-content: center;flex-wrap: wrap;"> <rn-template-item class="blank" @click="${()=>this.SendResult({Type:"entrypost",SubType:"blank",IsPr:!0})}" .title="${"Blank"}" .description="${"Create your template from scratch"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/blank.png"/>`}"></rn-template-item> </div> `),new p.RNTabItem("Carousel","Carousel",null,a.html` <div style="display: flex;flex-direction: row;justify-content: center;flex-wrap: wrap;"> <rn-template-item class="blank" @click="${()=>this.SendResult({Type:"carousel",SubType:"blank",IsPr:!0})}" .title="${"Blank"}" .description="${"Create your template from scratch"}" .icon="${a.html`<img src="${rnListVar.PluginUrl}images/TemplateIcons/blank.png"/>`}"></rn-template-item> </div> `)]}"> </rn-tabs> `}}),t.WpAjaxPost.SetGlobalVar(rnWorkflowListVar);let g=i.customElement("rn-pdflist")(m=class extends n.LitElementBase{constructor(...e){super(...e),this.FinalSearch="",this.TableIsBusy=!1,this.Data=rnWorkflowListVar.WorkflowList.Workflows,this.SortBy="page_name",this.Direction="asc",this.Search="",this.PageIndex=0,this.PageSize=30}static get properties(){return{TableIsBusy:{type:Boolean}}}render(){return a.html` <div style="margin:5px" class="rednao"> <h1>Workflow List</h1> <div style="display: flex;justify-content: space-between"> <div style="display: inline-flex"> <button @click="${e=>{e.preventDefault(),this.Create()}}" class="rnbtn rnbtn-success" style="display: flex;align-items: center;margin-right: 5px"> <rn-fontawesome .icon="${d.faPlus}" style="margin-right: 5px"></rn-fontawesome> <span>Create New Workflow</span></button> </div> <div style="display:inline-flex"> <input @keydown="${e=>{13==e.keyCode&&(this.FinalSearch=e.target.value.trim(),this.PageChanged(0,this.SortBy,this.Direction))}}" style="margin:0" class="rncontrol" type="text" placeholder="Search by name or id" value=${this.Search} @change="${e=>{this.Search=e.target.value,this.requestUpdate()}}"/> <rn-spinner-button @click="${()=>{this.FinalSearch=this.Search,this.PageChanged(0,this.SortBy,this.Direction)}}" .isBusy="${this.TableIsBusy}" .icon="${u.faSearch}" label="Search Workflow"> </rn-spinner-button> </div> </div> <rn-wptable .emptyText="${a.html`<p>No workflow was found <a href="#" @click="${e=>{e.preventDefault(),this.Create()}}">click here to create one</a> </p>`}" @actionClicked="${e=>this.ActionClicked(e.detail.Action,e.detail.Row,e)}" style="margin-top: 10px" .tableIsBusy="${this.TableIsBusy}" .Data="${this.Data}" .Rows="${rnWorkflowListVar.Records}" .totalNumberOfRows="${rnWorkflowListVar.Count}" .pageIndex="${this.PageIndex}" .pageSize="${this.PageSize}" @pageSizeChanged="${e=>{this.PageSize=e.detail,this.PageChanged(0,"","")}}" @pageChanged="${e=>{this.PageIndex=e.detail,this.PageChanged(this.PageIndex,this.SortBy,this.Direction),this.forceUpdate()}}" .availableSizes="${[{Label:"30",Size:30},{Label:"60",Size:60},{Label:"90",Size:90}]}" .Columns="${[new l.WPTableColumn("Name","Name","60").SetActions([{Id:"Edit",Title:"Edit"},{Id:"Delete",Title:"Delete"}]),new l.WPTableColumn("Type","TriggerType","20").AddFormatter(((e,t)=>{switch(e){case"entry_deleted":return"Entry Deleted";case"entry_updated":return"Entry Updated";case"form_submitted":return"Form Submitted"}return e})),new l.WPTableColumn("Form Used","Id","20").AddFormatter(((e,t)=>{var i;return null===(i=rnWorkflowListVar.WorkflowList.Forms.find((e=>e.Id==t.FormId)))||void 0===i?void 0:i.Name}))]}"> </rn-wptable> </div> `}async PageChanged(e,i,n){this.TableIsBusy=!0;let a=await t.WpAjaxPost.Post("list_workflows",{SortBy:i,PageSize:this.PageSize,Index:e,Direction:n,Search:this.FinalSearch});this.TableIsBusy=!1,null!=a&&(this.Data=a.Result,rnWorkflowListVar.Count=a.Count,this.PageIndex=e,this.SortBy=i,this.Direction=n,this.forceUpdate())}async OpenTemplate(e,t){t.preventDefault();let i=rnWorkflowListVar.TemplateURL+"&templateId="+e;t.shiftKey||t.ctrlKey?window.open(i):window.location.href=i}async ActionClicked(e,i,n){switch(e){case"Edit":window.location.href=rnWorkflowListVar.TemplateURL+"&id="+i.Id;break;case"Delete":await r.DeleteDialog.Show("Are you sure?","Are you sure you want to delete "+i.Name+"?",(async()=>{let e=await t.WpAjaxPost.Post("delete_workflow",{Id:i.Id});return null!=e&&(rnWorkflowListVar.WorkflowList.Workflows.splice(rnWorkflowListVar.WorkflowList.Workflows.indexOf(i),1),this.forceUpdate()),null!=e}))}}async Create(){window.location.href=rnWorkflowListVar.TemplateURL+"&id=0"}Preview(e){let t=document.createElement("form");document.body.appendChild(t),t.style.display="none",t.action=rnListVar.ajaxurl,t.method="post",t.target="_blank";let i=document.createElement("input");i.type="hidden",i.value=rnListVar._prefix+"_Preview",i.name="action",t.appendChild(i);let n=document.createElement("input");n.type="hidden",n.value=e,n.name="templateId",t.appendChild(n);let a=document.createElement("input");a.type="hidden",a.value=rnListVar._nonce,a.name="_nonce",t.appendChild(a),t.submit()}})||m;a.render(a.html`<rn-pdflist></rn-pdflist>`,document.getElementById("app")),e.WorkflowList=g,Object.defineProperty(e,"__esModule",{value:!0})}));
