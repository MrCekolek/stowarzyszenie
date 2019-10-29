import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-permission-group',
  templateUrl: './permission-group.component.html',
  styleUrls: ['./permission-group.component.scss']
})
export class PermissionGroupComponent implements OnInit {

  @Input() permissionGroupObj;

  constructor() { }

  ngOnInit() {
  }

  // click event on parent checkbox
  parentClick(parentObj) {
    for (let i = 0; i < parentObj.childList.length; i++) {
      parentObj.childList[i].isSelected = parentObj.isSelected;
    }
  }

  // click event on child checkbox
  childClick(parentObj, childObj) {
    parentObj.isSelected = parentObj.childList.every(function (itemChild: any) {
      return itemChild.isSelected == true;
    })

    
  }

  // collapse event on parent
  expandCollapse(obj){
    obj.isClosed = !obj.isClosed;
  }
}
