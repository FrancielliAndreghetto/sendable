import { PUT } from "@/lib/api";
import { IInstance } from "@/types";
import { PutRoutes } from "@/types/api/PutRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface UpdateInstanceData {
  name?: string;
  number?: string;
  platform?: 'whatsapp' | 'telegram' | 'instagram';
}

interface UpdateInstanceResponse {
  instance: IInstance;
}

const useUpdateInstance = () => {
  const queryClient = useQueryClient();

  return useMutation<UpdateInstanceResponse, Error, { id: string; data: UpdateInstanceData }>({
    mutationFn: async ({ id, data }: { id: string; data: UpdateInstanceData }) => {
      const res = await PUT<UpdateInstanceResponse>({
        route: PutRoutes.UpdateInstance,
        params: { id },
        body: data,
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetInstances] });
    },
  });
};

export default useUpdateInstance;
