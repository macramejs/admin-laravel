import { useIndex } from "@macramejs/macrame-vue3";
import { User } from "@admin/types/resources";

export const userIndex = useIndex<User>({
    route: "/admin/user/items",
    syncUrl: true,
    sortBy: [],
});
