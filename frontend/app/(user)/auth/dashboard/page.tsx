// app/(user)/auth/dashboard/page.tsx
import type { Metadata } from "next";
import DashboardPageClient from "./DashboardPageClient";

export const metadata: Metadata = {
  title: "Experiment 01 - Crafted.is",
};

export default function Page() {
  return <DashboardPageClient />;
}
