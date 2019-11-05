import { Component, OnInit } from '@angular/core';
import { PermissionRoleService } from "../../../core/http/permission-role.service";

@Component({
  selector: 'app-roles-list',
  templateUrl: './roles-list.component.html',
  styleUrls: ['./roles-list.component.scss']
})
export class RolesListComponent implements OnInit {

  roles: any;

  constructor(
    private permissionRoleService: PermissionRoleService
  ) {
    this.roles = {};
    this.roles.isAllSelected = false;
    this.roles.isAllCollapsed = false;

    this.roles.parentChildChecklist = [
      {
        id: 1, value: 'PermissionParent 1', isSelected: false, isClosed: false,
        childList: [
          {
            id: 1, parent_id: 1, value: 'child 1', isSelected: false
          },
          {
            id: 2, parent_id: 1, value: 'child 2', isSelected: false
          }
        ]
      },
      {
        id: 2,value: 'Caden Kunze',isSelected: false,isClosed:false,childList: [
          {
            id: 1,parent_id: 1,value: 'child 1',isSelected: false
          },
          {
            id: 2,parent_id: 1,value: 'child 2',isSelected: false
          }
        ]
      },
      {
        id: 3,value: 'Ms. Hortense Zulauf',isSelected: false,isClosed:false,
        childList: [
          {
            id: 1,parent_id: 1,value: 'child 1',isSelected: false
          },
          {
            id: 2,parent_id: 1,value: 'child 2',isSelected: false
          }
        ]
      }
    ];
  }

  ngOnInit() {
    this.permissionRoleService.getRoleWithPermissions(2).subscribe(
      roles => {
        console.log(roles);
      }
    )
  }

  // click event on check/uncheck all
  selectUnselectAll(obj) {
    obj.isAllSelected = !obj.isAllSelected;
    for (let i = 0; i < obj.parentChildChecklist.length; i++) {
      obj.parentChildChecklist[i].isSelected = obj.isAllSelected;
      for (let j = 0; j < obj.parentChildChecklist[i].childList.length; j++) {
        obj.parentChildChecklist[i].childList[j].isSelected = obj.isAllSelected;
      }
    }
  }

  // collapse all event
  expandCollapseAll(obj){
    for (let i = 0; i < obj.parentChildChecklist.length; i++) {
      obj.parentChildChecklist[i].isClosed = !obj.isAllCollapsed;
    }
    obj.isAllCollapsed = !obj.isAllCollapsed;
  }

  // show updated JSON
  stringify(obj) {
    return JSON.stringify(obj);
  }
}
