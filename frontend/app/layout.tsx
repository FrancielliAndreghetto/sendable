import { Inter } from "next/font/google";
import { mainFont } from "@/lib/fonts"; // se quiser continuar usando mainFont, pode manter ou remover
import { WrapperProps } from "@/types";
import "@/styles/globals.css";
import QueryProvider from "@/components/layout/QueryProvider";
import { Toaster } from "@/components/ui/sonner";
import LoadingOverlay from "@/components/LoadingOverlay";
import Navbar from "@/components/layout/Navbar";
import ThemeProvider from "@/components/layout/ThemeProvider";

const fontSans = Inter({
  subsets: ["latin"],
  variable: "--font-sans",
});

const RootLayout = ({ children }: WrapperProps) => {
  return (
    <html lang="en" suppressHydrationWarning className="dark scheme-only-dark">
      <body className={`${fontSans.variable} font-sans antialiased`}>
        <QueryProvider>
          <ThemeProvider
            attribute="class"
            defaultTheme="dark"
            enableSystem={false}
            disableTransitionOnChange
          >
            <Navbar />
            {children}
            <Toaster />
            <LoadingOverlay />
          </ThemeProvider>
        </QueryProvider>
      </body>
    </html>
  );
};

export { metadata } from "./metadata";

export default RootLayout;
